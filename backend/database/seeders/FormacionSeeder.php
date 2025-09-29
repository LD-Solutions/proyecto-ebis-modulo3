<?php

namespace Database\Seeders;

use App\Models\Formacion;
use Illuminate\Database\Seeder;

class FormacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Formacion::factory()
            ->count(12)
            ->create();
    }
}
