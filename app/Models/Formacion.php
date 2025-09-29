<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formacion extends Model
{
    use HasFactory;

    protected $table = 'formacions';

    protected $fillable = [
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

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_inicio' => 'datetime'
    ];
}
