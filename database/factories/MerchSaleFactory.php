<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MerchSaleFactory extends Factory
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
            'item_name' => fake()->word,
            'amount' => fake()->numberBetween(1,10),
            'price' => fake()->numberBetween(20,100),
            'currency_id' => 1,
            'created_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
