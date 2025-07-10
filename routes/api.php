<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NoticiasController;
use App\Http\Controllers\Api\EmpleadosController;
use App\Http\Controllers\Api\CalculadoraAhorrosController;
use App\Http\Controllers\Api\MensajesContactoController;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\FormacionController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');


Route::get('calculadora-ahorros', [CalculadoraAhorrosController::class, 'index']);
Route::get('calculadora-ahorros/{id}', [CalculadoraAhorrosController::class, 'show']);
Route::put('calculadora-ahorros/{id}', [CalculadoraAhorrosController::class, 'update']);
Route::delete('calculadora-ahorros/{id}', [CalculadoraAhorrosController::class, 'destroy']);

Route::apiResource('mensajes-contacto', MensajesContactoController::class);
Route::apiResource('noticias', NoticiasController::class);
Route::apiResource('empleados', EmpleadosController::class);
Route::apiResource('portfolios', PortfolioController::class);
Route::apiResource('formaciones', FormacionController::class);