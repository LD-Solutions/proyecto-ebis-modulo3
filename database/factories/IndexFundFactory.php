<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IndexFund>
 */
class IndexFundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'S&P 500 Index Fund',
                'Total Stock Market Index Fund',
                'International Stock Index Fund',
                'Bond Index Fund',
                'Real Estate Index Fund'
            ]),
            'symbol' => $this->faker->unique()->lexify('????'),
            'expense_ratio' => $this->faker->randomFloat(4, 0.0001, 0.0150),
            'aum' => $this->faker->randomFloat(2, 1000000, 100000000000),
            'description' => $this->faker->paragraph()
        ];
    }
}
