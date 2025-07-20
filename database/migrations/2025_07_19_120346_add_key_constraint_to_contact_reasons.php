<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add a check constraint to ensure only valid enum values are allowed
        $validKeys = "'termin','frage','beschwerde','notfall','rezept','ueberweisung','beratung','sonstiges'";
        
        // Add check constraint using raw SQL (key is reserved word, so use backticks)
        DB::statement("ALTER TABLE contact_reasons ADD CONSTRAINT contact_reasons_key_enum_check CHECK (`key` IN ($validKeys))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the check constraint
        DB::statement("ALTER TABLE contact_reasons DROP CONSTRAINT contact_reasons_key_enum_check");
    }
};
