<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Finsmart API",
 *     version="0.0.1",
 *     description="API REST para aplicaciones financieras con autenticación",
 *     @OA\Contact(
 *         email="admin@example.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor de desarrollo"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
abstract class Controller
{
    //
}
