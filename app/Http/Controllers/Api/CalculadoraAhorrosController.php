<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalculadoraAhorros;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CalculadoraAhorrosController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/calculadora-ahorros",
     *     summary="Listar todas las calculadoras de ahorros",
     *     description="Obtiene una lista de todas las calculadoras de ahorros registradas con campos calculados",
     *     operationId="indexCalculadoraAhorros",
     *     tags={"Calculadora Ahorros"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de calculadoras obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="ingreso_mensual", type="number", format="decimal", example=2500.50),
     *                 @OA\Property(property="id_usuario", type="integer", example=1),
     *                 @OA\Property(property="necesidad", type="number", format="decimal", example=1250.25, description="50% del ingreso mensual"),
     *                 @OA\Property(property="ocio", type="number", format="decimal", example=750.15, description="30% del ingreso mensual"),
     *                 @OA\Property(property="ahorros", type="number", format="decimal", example=500.10, description="20% del ingreso mensual"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-10T12:00:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-10T12:00:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $calculadoras = CalculadoraAhorros::all();

        foreach ($calculadoras as $calculadora) {
            $calculadora->necesidad = round($calculadora->ingreso_mensual * 0.50, 2);
            $calculadora->ocio = round($calculadora->ingreso_mensual * 0.30, 2);
            $calculadora->ahorros = round($calculadora->ingreso_mensual * 0.20, 2);
        }

        return response()->json($calculadoras, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/calculadora-ahorros/{id}",
     *     summary="Mostrar calculadora por ID de usuario",
     *     description="Obtiene los detalles de la calculadora de ahorros de un usuario específico usando el ID del usuario",
     *     operationId="showCalculadoraAhorros",
     *     tags={"Calculadora Ahorros"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario propietario de la calculadora",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Calculadora encontrada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="ingreso_mensual", type="number", format="decimal", example=2500.50),
     *             @OA\Property(property="id_usuario", type="integer", example=1),
     *             @OA\Property(property="necesidad", type="number", format="decimal", example=1250.25, description="50% del ingreso mensual"),
     *             @OA\Property(property="ocio", type="number", format="decimal", example=750.15, description="30% del ingreso mensual"),
     *             @OA\Property(property="ahorros", type="number", format="decimal", example=500.10, description="20% del ingreso mensual"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-10T12:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-10T12:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario o calculadora no encontrados",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Este usuario no tiene calculadora de ahorros")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $usuario = User::findOrFail($id);

            $calculadora = CalculadoraAhorros::where('id_usuario', $id)->firstOrFail();

            $calculadora->necesidad = round($calculadora->ingreso_mensual * 0.50, 2);
            $calculadora->ocio = round($calculadora->ingreso_mensual * 0.30, 2);
            $calculadora->ahorros = round($calculadora->ingreso_mensual * 0.20, 2);

            return response()->json($calculadora, 200);
        } catch (ModelNotFoundException $e) {
            $usuario = User::find($id);
            if (!$usuario) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            } else {
                return response()->json(['message' => 'Este usuario no tiene calculadora de ahorros'], 404);
            }
        }
    }

    /**
     * @OA\Put(
     *     path="/api/calculadora-ahorros/{id}",
     *     summary="Actualizar calculadora por ID de usuario",
     *     description="Actualiza la calculadora de ahorros de un usuario específico usando el ID del usuario",
     *     operationId="updateCalculadoraAhorros",
     *     tags={"Calculadora Ahorros"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario propietario de la calculadora",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         description="Datos para actualizar la calculadora",
     *         @OA\JsonContent(
     *             @OA\Property(property="ingreso_mensual", type="number", format="decimal", example=3000.75, description="Ingreso mensual del usuario (opcional)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Calculadora actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="ingreso_mensual", type="number", format="decimal", example=3000.75),
     *             @OA\Property(property="id_usuario", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-10T12:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-10T12:30:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario o calculadora no encontrados",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Este usuario no tiene calculadora de ahorros")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación o datos vacíos",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="ingreso_mensual", type="array", @OA\Items(type="string", example="El ingreso mensual debe ser un número."))
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="error", type="string", example="Debes enviar al menos un campo correcto para actualizar.")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     * 
     **/
    public function update(Request $request, string $id)
    {
        try {
            $usuario = User::findOrFail($id);
            $calculadora = CalculadoraAhorros::where('id_usuario', $id)->firstOrFail();

            $validatedData = $request->validate(
                [
                    'ingreso_mensual' => 'sometimes|filled|numeric|min:0|max:999999999.99',
                ],
                [
                    'ingreso_mensual.numeric' => 'El ingreso mensual debe ser un número.',
                    'ingreso_mensual.min' => 'El ingreso mensual no puede ser negativo.',
                    'ingreso_mensual.max' => 'El ingreso mensual es demasiado grande.',
                ]
            );
        } catch (ModelNotFoundException $e) {
            $usuario = User::find($id);
            if (!$usuario) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }

        if (empty($validatedData)) {
            return response()->json([
                'error' => 'Debes enviar al menos un campo correcto para actualizar.',
            ], 422);
        }

        $calculadora->fill($validatedData);
        $calculadora->save();

        return response()->json($calculadora, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/calculadora-ahorros/{id}",
     *     summary="Resetear calculadora por ID de usuario",
     *     description="Resetea la calculadora de ahorros de un usuario específico (pone el ingreso mensual en 0) usando el ID del usuario",
     *     operationId="destroyCalculadoraAhorros",
     *     tags={"Calculadora Ahorros"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del usuario propietario de la calculadora",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Calculadora reseteada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Calculadora reseteada correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario o calculadora no encontrados",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Usuario no encontrado")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="message", type="string", example="Este usuario no tiene calculadora de ahorros")
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $usuario = User::findOrFail($id);

            $calculadora = CalculadoraAhorros::where('id_usuario', $id)->firstOrFail();

            $calculadora->ingreso_mensual = 0;
            $calculadora->save();

            return response()->json(['message' => 'Calculadora reseteada correctamente'], 200);
        } catch (ModelNotFoundException $e) {
            $usuario = User::find($id);
            if (!$usuario) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            } else {
                return response()->json(['message' => 'Este usuario no tiene calculadora de ahorros'], 404);
            }
        }
    }
}
