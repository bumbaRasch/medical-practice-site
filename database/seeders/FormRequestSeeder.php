<?php

namespace Database\Seeders;

use App\Models\FormRequest;
use Illuminate\Database\Seeder;

class FormRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 form requests
        FormRequest::factory()->count(20)->create();
        
        // Create 5 form requests with complete data
        FormRequest::factory()->count(5)->create([
            'phone' => fake('de_DE')->phoneNumber(),
            'preferred_datetime' => fake()->dateTimeBetween('now', '+2 months'),
            'message' => fake()->randomElement([
                'Ich würde gerne einen Termin für eine Routineuntersuchung vereinbaren.',
                'Ich benötige eine Überweisung zum Facharzt.',
                'Möchte einen Termin für die jährliche Gesundheitsuntersuchung.',
            ]),
        ]);
    }
}
