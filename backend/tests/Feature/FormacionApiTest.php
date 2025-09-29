<?php

namespace Tests\Feature;

use App\Models\Formacion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FormacionApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_get_formacion_list(): void
    {
        Formacion::factory()->count(5)->create();

        $response = $this->getJson('/api/formaciones');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'titulo',
                            'descripcion',
                            'instructor',
                            'precio',
                            'tipo',
                            'categoria',
                            'nivel'
                        ]
                    ],
                    'links',
                    'total',
                    'per_page',
                    'current_page'
                ]);
    }

    public function test_can_filter_formacion_by_tipo(): void
    {
        Formacion::factory()->create(['tipo' => 'libro']);
        Formacion::factory()->create(['tipo' => 'curso']);
        Formacion::factory()->create(['tipo' => 'video']);

        $response = $this->getJson('/api/formaciones?tipo=libro');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('total'));
        $this->assertEquals('libro', $response->json('data.0.tipo'));
    }

    public function test_can_filter_formacion_by_categoria(): void
    {
        Formacion::factory()->create(['categoria' => 'finanzas']);
        Formacion::factory()->create(['categoria' => 'trading']);

        $response = $this->getJson('/api/formaciones?categoria=finanzas');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('total'));
        $this->assertEquals('finanzas', $response->json('data.0.categoria'));
    }

    public function test_can_filter_formacion_by_nivel(): void
    {
        Formacion::factory()->create(['nivel' => 'principiante']);
        Formacion::factory()->create(['nivel' => 'avanzado']);

        $response = $this->getJson('/api/formaciones?nivel=principiante');

        $response->assertStatus(200);
        $this->assertEquals(1, $response->json('total'));
        $this->assertEquals('principiante', $response->json('data.0.nivel'));
    }

    public function test_can_get_single_formacion(): void
    {
        $formacion = Formacion::factory()->create();

        $response = $this->getJson("/api/formaciones/{$formacion->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $formacion->id,
                    'titulo' => $formacion->titulo,
                    'tipo' => $formacion->tipo
                ]);
    }

    public function test_can_create_formacion_with_authentication(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $formacionData = [
            'titulo' => 'Test Curso',
            'descripcion' => 'Descripción del curso de prueba',
            'instructor' => 'Juan Pérez',
            'precio' => 99.99,
            'tipo' => 'curso',
            'categoria' => 'finanzas',
            'nivel' => 'principiante',
            'duracion_horas' => 20
        ];

        $response = $this->postJson('/api/formaciones', $formacionData);

        $response->assertStatus(201)
                ->assertJson($formacionData);
        
        $this->assertDatabaseHas('formacions', $formacionData);
    }

    public function test_cannot_create_formacion_without_authentication(): void
    {
        $formacionData = [
            'titulo' => 'Test Curso',
            'descripcion' => 'Descripción del curso',
            'instructor' => 'Juan Pérez',
            'precio' => 99.99,
            'tipo' => 'curso',
            'categoria' => 'finanzas',
            'nivel' => 'principiante'
        ];

        $response = $this->postJson('/api/formaciones', $formacionData);

        $response->assertStatus(401);
    }

    public function test_can_create_libro_with_file_path(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $libroData = [
            'titulo' => 'Libro de Inversiones',
            'descripcion' => 'Un libro completo sobre inversiones',
            'instructor' => 'Ana García',
            'precio' => 29.99,
            'tipo' => 'libro',
            'categoria' => 'inversiones',
            'nivel' => 'intermedio',
            'archivo_path' => 'libros/introduccion-inversiones.txt',
            'paginas' => 150
        ];

        $response = $this->postJson('/api/formaciones', $libroData);

        $response->assertStatus(201)
                ->assertJson($libroData);
    }

    public function test_can_create_video_with_url(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $videoData = [
            'titulo' => 'Video Tutorial Trading',
            'descripcion' => 'Tutorial completo de trading',
            'instructor' => 'Carlos López',
            'precio' => 19.99,
            'tipo' => 'video',
            'categoria' => 'trading',
            'nivel' => 'principiante',
            'duracion_horas' => 3,
            'url_video' => 'https://youtube.com/watch?v=abc123'
        ];

        $response = $this->postJson('/api/formaciones', $videoData);

        $response->assertStatus(201)
                ->assertJson($videoData);
    }

    public function test_validation_fails_for_invalid_tipo(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $invalidData = [
            'titulo' => 'Test',
            'descripcion' => 'Test',
            'instructor' => 'Test',
            'precio' => 99,
            'tipo' => 'invalid_type',
            'categoria' => 'finanzas',
            'nivel' => 'principiante'
        ];

        $response = $this->postJson('/api/formaciones', $invalidData);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['tipo']);
    }

    public function test_can_update_formacion_with_authentication(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $formacion = Formacion::factory()->create();
        
        $updateData = [
            'titulo' => 'Título Actualizado',
            'precio' => 149.99
        ];

        $response = $this->putJson("/api/formaciones/{$formacion->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson($updateData);
    }

    public function test_can_delete_formacion_with_authentication(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $formacion = Formacion::factory()->create();

        $response = $this->deleteJson("/api/formaciones/{$formacion->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('formacions', ['id' => $formacion->id]);
    }
}
