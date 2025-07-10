<?php

namespace Database\Seeders;

/* use Illuminate\Database\Console\Seeds\WithoutModelEvents; */
use Illuminate\Database\Seeder;
use App\Models\CalculadoraAhorros;
use App\Models\User;

class CalculadoraAhorrosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            CalculadoraAhorros::factory()
                ->count(1)
                ->create(['id_usuario' => $user->id]);
        }
    }
}
