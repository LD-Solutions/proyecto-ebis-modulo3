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
        $funds = [
            [
                'name' => 'Vanguard S&P 500 ETF',
                'description' => 'Tracks the investment performance of the S&P 500 Index, representing 500 of the largest U.S. companies.',
            ],
            [
                'name' => 'Vanguard Total Stock Market ETF',
                'description' => 'Seeks to track the performance of the entire U.S. stock market, including small-, mid-, and large-cap growth and value stocks.',
            ],
            [
                'name' => 'Vanguard Total International Stock ETF',
                'description' => 'Seeks to track the performance of non-U.S. stock markets, providing broad international equity exposure.',
            ],
            [
                'name' => 'Vanguard Total Bond Market ETF',
                'description' => 'Seeks to track the performance of the Bloomberg U.S. Aggregate Float Adjusted Index, covering the entire U.S. investment-grade bond market.',
            ],
            [
                'name' => 'Vanguard Real Estate ETF',
                'description' => 'Seeks to track the performance of the MSCI US Investable Market Real Estate 25/50 Index, investing in REITs and real estate companies.',
            ],
            [
                'name' => 'iShares Core MSCI Total International Stock ETF',
                'description' => 'Seeks to track the performance of the MSCI ACWI ex USA Investable Market Index, providing exposure to international developed and emerging markets.',
            ],
            [
                'name' => 'SPDR S&P 500 ETF Trust',
                'description' => 'Seeks to track the performance of the S&P 500 Index, one of the most widely followed equity indices in the world.',
            ],
            [
                'name' => 'iShares Core U.S. Aggregate Bond ETF',
                'description' => 'Seeks to track the performance of the Bloomberg U.S. Aggregate Bond Index, representing the broad U.S. bond market.',
            ],
        ];

        $selectedFund = $this->faker->randomElement($funds);

        return [
            'name' => $selectedFund['name'],
            'symbol' => $this->faker->unique()->lexify('????'),
            'expense_ratio' => $this->faker->randomFloat(4, 0.0001, 0.0150),
            'aum' => $this->faker->randomFloat(2, 1000000, 100000000000),
            'current_price' => $this->faker->randomFloat(2, 50, 500),
            'description' => $selectedFund['description']
        ];
    }
}
