<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Try to get existing IndexFund symbols, fallback to creating one if none exist
        $indexFunds = \App\Models\IndexFund::pluck('symbol')->toArray();
        $symbol = !empty($indexFunds) 
            ? $this->faker->randomElement($indexFunds)
            : \App\Models\IndexFund::factory()->create()->symbol;

        return [
            'symbol' => $symbol,
            'shares' => $this->faker->randomFloat(2, 1, 100),
            'purchase_price' => $this->faker->randomFloat(2, 50, 500),
            'id_usuario' => \App\Models\User::factory()
        ];
    }
}
