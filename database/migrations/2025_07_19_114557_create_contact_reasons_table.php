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
        Schema::create('contact_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Unique identifier for the reason');
            $table->json('name')->comment('Localized names (JSON: {"de": "German", "en": "English"})');
            $table->integer('sort_order')->default(0)->comment('Display order');
            $table->boolean('is_active')->default(true)->comment('Whether this reason is available for selection');
            $table->timestamps();
            
            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_reasons');
    }
};
