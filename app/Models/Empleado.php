<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    /** @use HasFactory<\Database\Factories\EmpleadoFactory> */
    use HasFactory;
    protected $connection = 'sqlite';
    protected $table = 'empleados';

    protected $fillable = [
        'nombre',
        'apellido',
        'cargo',
        'imagen_url'
    ];
}
