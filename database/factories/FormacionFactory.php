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
        $tipo = $this->faker->randomElement(['curso', 'video', 'libro', 'webinar']);
        $categoria = $this->faker->randomElement(['finanzas', 'inversiones', 'trading', 'criptomonedas']);
        
        $data = [
            'titulo' => $this->faker->sentence(4),
            'descripcion' => $this->faker->paragraph(3),
            'instructor' => $this->faker->name(),
            'precio' => $this->faker->randomFloat(2, 0, 199),
            'tipo' => $tipo,
            'categoria' => $categoria,
            'nivel' => $this->faker->randomElement(['principiante', 'intermedio', 'avanzado']),
        ];
        
        return $this->applyTipoAttributes($data, $tipo);
    }

    public function configure()
    {
        return $this->afterMaking(function (\App\Models\Formacion $formacion) {
            $data = $this->applyTipoAttributes($formacion->toArray(), $formacion->tipo);
            $formacion->forceFill($data);
        });
    }

    private function applyTipoAttributes(array $data, string $tipo): array
    {
        switch ($tipo) {
            case 'curso':
                $data['duracion_horas'] = $this->faker->numberBetween(10, 80);
                $data['fecha_inicio'] = $this->faker->dateTimeBetween('now', '+3 months');
                break;
                
            case 'video':
                $data['duracion_horas'] = $this->faker->numberBetween(1, 8);
                $data['url_video'] = 'https://youtube.com/watch?v=' . $this->faker->regexify('[A-Za-z0-9]{11}');
                break;
                
            case 'libro':
                $data['paginas'] = $this->faker->numberBetween(50, 300);
                $data['archivo_path'] = 'libros/' . $this->faker->randomElement([
                    'introduccion-inversiones.txt',
                    'trading-para-principiantes.txt', 
                    'criptomonedas-guia-completa.txt',
                    'planificacion-financiera-personal.txt'
                ]);
                $data['precio'] = $this->faker->randomFloat(2, 0, 49);
                break;
                
            case 'webinar':
                $data['duracion_horas'] = $this->faker->numberBetween(1, 3);
                $data['fecha_inicio'] = $this->faker->dateTimeBetween('now', '+1 month');
                break;
        }
        
        return $data;
    }
}
