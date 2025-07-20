<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactReason>
 */
class ContactReasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $keys = ['termin', 'frage', 'beschwerde', 'notfall', 'rezept', 'ueberweisung', 'beratung', 'sonstiges'];
        $key = fake()->randomElement($keys);
        
        return [
            'key' => $key,
            'name' => [
                'de' => ucfirst($key),
                'en' => ucfirst($key),
            ],
            'sort_order' => fake()->numberBetween(1, 10),
            'is_active' => true,
        ];
    }
}
