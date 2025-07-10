<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculadoraAhorros extends Model
{
    /** @use HasFactory<\Database\Factories\CalculadoraAhorrosFactory> */
    use HasFactory;

    protected $connection = 'sqlite';
    protected $table = 'calculadora_ahorros';

    protected $fillable = [
        'ingreso_mensual',
        'id_usuario'
    ];
}
