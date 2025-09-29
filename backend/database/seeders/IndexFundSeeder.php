<?php

namespace Database\Seeders;

use App\Models\IndexFund;
use Illuminate\Database\Seeder;

class IndexFundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IndexFund::factory()
            ->count(15)
            ->create();
    }
}
