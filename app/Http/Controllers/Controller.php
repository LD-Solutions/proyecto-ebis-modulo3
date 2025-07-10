<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Finsmart API",
 *     version="0.0.1",
 *     description="API REST para aplicaciones financieras con autenticación",
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
 * 
 * @OA\Tag(
 *     name="Authentication",
 *     description="Gestión de autenticación de usuarios"
 * )
 * 
 * @OA\Tag(
 *     name="Noticias",
 *     description="Gestión de noticias financieras"
 * )
 * 
 * @OA\Tag(
 *     name="Empleados",
 *     description="Gestión de empleados"
 * )
 * 
 * @OA\Tag(
 *     name="Calculadora Ahorros",
 *     description="Calculadora de ahorros 50/30/20"
 * )
 * 
 * @OA\Tag(
 *     name="Mensajes de Contacto",
 *     description="Gestión de mensajes de contacto"
 * )
 * 
 * @OA\Tag(
 *     name="Formación",
 *     description="Gestión de contenido educativo financiero"
 * )
 * 
 * @OA\Tag(
 *     name="Portfolio",
 *     description="Gestión de portafolio de inversiones"
 * )
 */
abstract class Controller
{
    //
}
