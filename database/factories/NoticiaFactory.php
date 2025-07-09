<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Noticia>
 */
class NoticiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(6, true),
            'contenido' => $this->faker->paragraphs(5, true),
            'autor' => $this->faker->name(),
            'categoria' => $this->faker->randomElement(['deportes', 'tecnología', 'política', 'economía', 'cultura', 'salud']),
            'imagen_url' => $this->faker->imageUrl(640, 480, 'news', true),
            'fecha_publicacion' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'publicado' => $this->faker->boolean(85)
        ];
    }
}
