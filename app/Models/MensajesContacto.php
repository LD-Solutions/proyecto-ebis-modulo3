<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajesContacto extends Model
{
    /** @use HasFactory<\Database\Factories\MensajesContactoFactory> */
    use HasFactory;
    protected $connection = 'sqlite';
    protected $table = 'mensajes_contacto';

    protected $fillable = [
        'nombre_apellidos',
        'email',
        'telefono',
        'mensaje'
    ];
}