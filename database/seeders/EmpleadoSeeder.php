<?php

namespace Database\Seeders;

/* use Illuminate\Database\Console\Seeds\WithoutModelEvents; */
use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Empleado::factory()
            ->count(6)
            ->create();


    }
}
