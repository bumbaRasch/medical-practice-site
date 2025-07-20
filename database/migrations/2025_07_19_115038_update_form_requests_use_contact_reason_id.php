<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('form_requests', function (Blueprint $table) {
            // Add the new foreign key column
            $table->foreignId('contact_reason_id')->after('email')->constrained('contact_reasons');
            
            // Remove the old reason column
            $table->dropColumn('reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_requests', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['contact_reason_id']);
            $table->dropColumn('contact_reason_id');
            
            // Add back the old reason column
            $table->string('reason')->after('email')->comment('Contact reason from ContactReason enum');
        });
    }
};
