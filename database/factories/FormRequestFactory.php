<?php

namespace Database\Factories;

use App\Models\ContactReason;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormRequest>
 */
class FormRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $germanMessages = [
            'Ich würde gerne einen Termin für eine Routineuntersuchung vereinbaren.',
            'Ich benötige eine Überweisung zum Facharzt.',
            'Können Sie mir bitte meine Laborergebnisse zusenden?',
            'Ich habe seit einigen Tagen Rückenschmerzen und würde gerne einen Termin vereinbaren.',
            'Benötige ein Rezept für meine Dauermedikation.',
            'Möchte einen Termin für die jährliche Gesundheitsuntersuchung.',
            'Ich brauche eine Krankschreibung für meinen Arbeitgeber.',
            'Hätte gerne einen Termin zur Besprechung meiner Blutwerte.',
            null,
        ];

        return [
            'full_name' => fake('de_DE')->name(),
            'email' => fake()->unique()->safeEmail(),
            'contact_reason_id' => ContactReason::inRandomOrder()->first()?->id ?? 1,
            'phone' => fake('de_DE')->optional(0.8)->phoneNumber(),
            'preferred_datetime' => fake()->optional(0.6)->dateTimeBetween('now', '+2 months'),
            'message' => fake()->optional(0.7)->randomElement($germanMessages),
        ];
    }
}
