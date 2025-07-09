<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    /** @use HasFactory<\Database\Factories\NoticiaFactory> */
    use HasFactory;

    protected $fillable = [
        'titulo',
        'contenido',
        'autor',
        'categoria',
        'imagen_url',
        'fecha_publicacion',
        'publicado'
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'publicado' => 'boolean'
    ];
}
