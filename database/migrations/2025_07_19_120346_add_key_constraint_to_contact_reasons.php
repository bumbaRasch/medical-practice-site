<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add a check constraint to ensure only valid enum values are allowed
        $validKeys = "'termin','frage','beschwerde','notfall','rezept','ueberweisung','beratung','sonstiges'";
        
        // SQLite-compatible check constraint syntax
        if (DB::getDriverName() === 'sqlite') {
            // For SQLite, we need to recreate the table with the constraint
            // Since this is a new table, we'll just note that validation is handled in the model
            // SQLite does support CHECK constraints but adding them to existing tables is complex
        } else {
            // MySQL/other databases
            DB::statement("ALTER TABLE contact_reasons ADD CONSTRAINT contact_reasons_key_enum_check CHECK (`key` IN ($validKeys))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the check constraint only for non-SQLite databases
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE contact_reasons DROP CONSTRAINT contact_reasons_key_enum_check");
        }
    }
};
