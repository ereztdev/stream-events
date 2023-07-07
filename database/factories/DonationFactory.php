<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'amount' => fake()->numberBetween(1, 100),
            'currency_id' => 1,
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
