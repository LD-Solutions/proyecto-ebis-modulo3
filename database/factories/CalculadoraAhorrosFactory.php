<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalculadoraAhorros>
 */
class CalculadoraAhorrosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ingreso_mensual' => $this->faker->numberBetween(1000, 5000)
            // el id_usuario se asigna en el propio seeder
        ];
    }
}
