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
 *     name="Autenticación",
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
 *     description="Gestión de calculadoras de ahorros de usuarios con el método 50/30/20, calculado en tiempo de ejecución. Se crea automáticamente cuando se crea un usuario, por lo que no necesitamos POST"
 * )
 * 
 * @OA\Tag(
 *     name="Mensajes de Contacto",
 *     description="Gestión de todas las solicitudes de contacto del formulario web"
 * )
 * 
 * @OA\Tag(
 *     name="Formación",
 *     description="Gestión de contenido educativo financiero: cursos, videos, libros y webinars con múltiples tipos de contenido"
 * )
 * 
 * @OA\Tag(
 *     name="Portfolio",
 *     description="Gestión de portafolio de inversiones con fondos índice, valoración dinámica y operaciones de compra/venta"
 * )
 */
abstract class Controller
{
    //
}
