<?php

namespace Tests\Unit;

use App\Models\Formacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormacionModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_formacion_has_correct_fillable_attributes(): void
    {
        $expectedFillable = [
            'titulo',
            'descripcion',
            'instructor',
            'duracion_horas',
            'precio',
            'tipo',
            'categoria',
            'nivel',
            'fecha_inicio',
            'archivo_path',
            'paginas',
            'url_video'
        ];

        $formacion = new Formacion();
        $this->assertEquals($expectedFillable, $formacion->getFillable());
    }

    public function test_formacion_casts_attributes_correctly(): void
    {
        $formacion = new Formacion();
        $casts = $formacion->getCasts();
        
        $this->assertEquals('decimal:2', $casts['precio']);
        $this->assertEquals('datetime', $casts['fecha_inicio']);
    }

    public function test_can_create_formacion_with_factory(): void
    {
        $formacion = Formacion::factory()->create();
        
        $this->assertInstanceOf(Formacion::class, $formacion);
        $this->assertNotNull($formacion->titulo);
        $this->assertNotNull($formacion->tipo);
        $this->assertContains($formacion->tipo, ['curso', 'video', 'libro', 'webinar']);
        $this->assertContains($formacion->nivel, ['principiante', 'intermedio', 'avanzado']);
    }

    public function test_libro_tipo_has_required_attributes(): void
    {
        $libro = Formacion::factory()->create(['tipo' => 'libro']);
        
        $this->assertEquals('libro', $libro->tipo);
        $this->assertNotNull($libro->archivo_path);
        $this->assertNotNull($libro->paginas);
        $this->assertTrue($libro->paginas > 0);
    }

    public function test_video_tipo_has_required_attributes(): void
    {
        $video = Formacion::factory()->create(['tipo' => 'video']);
        
        $this->assertEquals('video', $video->tipo);
        $this->assertNotNull($video->url_video);
        $this->assertStringContainsString('youtube.com', $video->url_video);
    }

    public function test_curso_tipo_has_required_attributes(): void
    {
        $curso = Formacion::factory()->create(['tipo' => 'curso']);
        
        $this->assertEquals('curso', $curso->tipo);
        $this->assertNotNull($curso->duracion_horas);
        $this->assertNotNull($curso->fecha_inicio);
        $this->assertTrue($curso->duracion_horas >= 10);
    }

    public function test_webinar_tipo_has_required_attributes(): void
    {
        $webinar = Formacion::factory()->create(['tipo' => 'webinar']);
        
        $this->assertEquals('webinar', $webinar->tipo);
        $this->assertNotNull($webinar->duracion_horas);
        $this->assertNotNull($webinar->fecha_inicio);
        $this->assertTrue($webinar->duracion_horas <= 3);
    }

    public function test_formacion_uses_correct_table_name(): void
    {
        $formacion = new Formacion();
        $this->assertEquals('formacions', $formacion->getTable());
    }

    public function test_precio_is_cast_to_decimal(): void
    {
        $formacion = Formacion::factory()->make(['precio' => 99.99, 'tipo' => 'curso']);
        $formacion->save();
        
        $this->assertEquals('99.99', $formacion->precio);
        $this->assertEquals(99.99, (float) $formacion->precio);
    }

    public function test_can_filter_by_categoria(): void
    {
        Formacion::factory()->create(['categoria' => 'finanzas']);
        Formacion::factory()->create(['categoria' => 'trading']);
        Formacion::factory()->create(['categoria' => 'finanzas']);

        $finanzasCount = Formacion::where('categoria', 'finanzas')->count();
        $tradingCount = Formacion::where('categoria', 'trading')->count();

        $this->assertEquals(2, $finanzasCount);
        $this->assertEquals(1, $tradingCount);
    }

    public function test_can_filter_by_nivel(): void
    {
        Formacion::factory()->create(['nivel' => 'principiante']);
        Formacion::factory()->create(['nivel' => 'avanzado']);
        Formacion::factory()->create(['nivel' => 'principiante']);

        $principianteCount = Formacion::where('nivel', 'principiante')->count();
        $avanzadoCount = Formacion::where('nivel', 'avanzado')->count();

        $this->assertEquals(2, $principianteCount);
        $this->assertEquals(1, $avanzadoCount);
    }
}
