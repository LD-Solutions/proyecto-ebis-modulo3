<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formacion>
 */
class FormacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(3),
            'instructor' => $this->faker->name(),
            'duracion_horas' => $this->faker->numberBetween(10, 100),
            'precio' => $this->faker->randomFloat(2, 99, 999),
            'categoria' => $this->faker->randomElement(['finanzas', 'inversiones', 'trading', 'criptomonedas', 'economia']),
            'nivel' => $this->faker->randomElement(['principiante', 'intermedio', 'avanzado']),
            'fecha_inicio' => $this->faker->dateTimeBetween('now', '+3 months')
        ];
    }
}
