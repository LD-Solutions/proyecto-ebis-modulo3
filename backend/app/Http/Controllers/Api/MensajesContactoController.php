<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\MensajesContacto;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class MensajesContactoController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['store']),
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/mensajes-contacto",
     *     tags={"Mensajes de Contacto"},
     *     summary="Listar mensajes de contacto",
     *     description="Obtiene la lista completa de mensajes de contacto registrados en el sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Listado completo de mensajes de contacto",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre_apellidos", type="string", example="Juan Carlos García López"),
     *                 @OA\Property(property="email", type="string", example="juan.garcia@ejemplo.com"),
     *                 @OA\Property(property="telefono", type="string", example="+34 612 345 678"),
     *                 @OA\Property(property="mensaje", type="string", example="Hola, me gustaría obtener más información sobre sus servicios..."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z")
     *             ),
     *             example={
     *                 {
     *                     "id": 1,
     *                     "nombre_apellidos": "Juan Carlos García López",
     *                     "email": "juan.garcia@ejemplo.com",
     *                     "telefono": "+34 612 345 678",
     *                     "mensaje": "Hola, me gustaría obtener más información sobre sus servicios...",
     *                     "created_at": "2024-01-15T10:30:00.000000Z",
     *                     "updated_at": "2024-01-15T10:30:00.000000Z"
     *                 },
     *                 {
     *                     "id": 2,
     *                     "nombre_apellidos": "María Elena Rodríguez Pérez",
     *                     "email": "maria.rodriguez@ejemplo.com",
     *                     "telefono": "+34 687 654 321",
     *                     "mensaje": "Buenos días, quisiera solicitar una cotización para...",
     *                     "created_at": "2024-01-16T14:25:00.000000Z",
     *                     "updated_at": "2024-01-16T14:25:00.000000Z"
     *                 }
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
    public function index()
    {
        $mensajesContacto = MensajesContacto::all();

        return response()->json($mensajesContacto, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/mensajes-contacto",
     *     tags={"Mensajes de Contacto"},
     *     summary="Crear mensaje de contacto",
     *     description="Crea un nuevo mensaje de contacto en el sistema",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del mensaje de contacto a crear",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"nombre_apellidos","email","telefono","mensaje"},
     *                 @OA\Property(
     *                     property="nombre_apellidos",
     *                     type="string",
     *                     description="Nombre completo de la persona que contacta",
     *                     example="Ana Patricia Martínez Silva"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="Dirección de correo electrónico",
     *                     example="ana.martinez@ejemplo.com"
     *                 ),
     *                 @OA\Property(
     *                     property="telefono",
     *                     type="string",
     *                     description="Número de teléfono de contacto",
     *                     example="+34 699 123 456"
     *                 ),
     *                 @OA\Property(
     *                     property="mensaje",
     *                     type="string",
     *                     description="Contenido del mensaje de contacto",
     *                     example="Estoy interesado en sus servicios de desarrollo web. ¿Podrían contactarme para discutir mi proyecto?"
     *                 )
     *             ),
     *             example={
     *                 "nombre_apellidos": "Ana Patricia Martínez Silva",
     *                 "email": "ana.martinez@ejemplo.com",
     *                 "telefono": "+34 699 123 456",
     *                 "mensaje": "Estoy interesado en sus servicios de desarrollo web. ¿Podrían contactarme para discutir mi proyecto?"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Mensaje de contacto creado satisfactoriamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Mensaje de contacto creado exitosamente."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="nombre_apellidos", type="string", example="Ana Patricia Martínez Silva"),
     *                 @OA\Property(property="email", type="string", example="ana.martinez@ejemplo.com"),
     *                 @OA\Property(property="telefono", type="string", example="+34 699 123 456"),
     *                 @OA\Property(property="mensaje", type="string", example="Estoy interesado en sus servicios de desarrollo web. ¿Podrían contactarme para discutir mi proyecto?"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-10T16:45:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-10T16:45:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="nombre_apellidos", type="array", @OA\Items(type="string", example="El campo nombre y apellidos es obligatorio.")),
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="El email debe tener un formato válido.")),
     *                 @OA\Property(property="telefono", type="array", @OA\Items(type="string", example="El campo teléfono es obligatorio.")),
     *                 @OA\Property(property="mensaje", type="array", @OA\Items(type="string", example="El campo mensaje es obligatorio."))
     *             )
     *         )
     *     )
     * )
     **/
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate(
                [
                    'nombre_apellidos' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'telefono' => 'required|string|max:20',
                    'mensaje' => 'required|string|max:1000',
                ],
                [
                    'nombre_apellidos.required' => 'El campo nombre y apellidos es obligatorio.',
                    'nombre_apellidos.string' => 'El nombre y apellidos debe ser texto válido.',
                    'nombre_apellidos.max' => 'El nombre y apellidos no puede exceder los 255 caracteres.',

                    'email.required' => 'El campo email es obligatorio.',
                    'email.email' => 'El email debe tener un formato válido.',
                    'email.max' => 'El email no puede exceder los 255 caracteres.',

                    'telefono.required' => 'El campo teléfono es obligatorio.',
                    'telefono.string' => 'El teléfono debe ser texto válido.',
                    'telefono.max' => 'El teléfono no puede exceder los 20 caracteres.',

                    'mensaje.required' => 'El campo mensaje es obligatorio.',
                    'mensaje.string' => 'El mensaje debe ser texto válido.',
                    'mensaje.max' => 'El mensaje no puede exceder los 1000 caracteres.',
                ]
            );

            $mensajeContacto = MensajesContacto::create($validatedData);

            return response()->json([
                'message' => 'Mensaje de contacto creado exitosamente.',
                'data' => $mensajeContacto
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al crear mensaje de contacto: ', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/mensajes-contacto/{id}",
     *     tags={"Mensajes de Contacto"},
     *     summary="Mostrar un mensaje de contacto",
     *     description="Obtiene los detalles de un mensaje de contacto específico por su ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del mensaje de contacto a consultar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mensaje de contacto encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nombre_apellidos", type="string", example="Juan Carlos García López"),
     *             @OA\Property(property="email", type="string", example="juan.garcia@ejemplo.com"),
     *             @OA\Property(property="telefono", type="string", example="+34 612 345 678"),
     *             @OA\Property(property="mensaje", type="string", example="Hola, me gustaría obtener más información sobre sus servicios..."),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mensaje de contacto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Mensaje de contacto no encontrado")
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
            $mensajeContacto = MensajesContacto::findOrFail($id);

            return response()->json($mensajeContacto, 200);
        } catch (ModelNotFoundException) {

            return response()->json(['error' => 'Mensaje de contacto no encontrado'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/mensajes-contacto/{id}",
     *     tags={"Mensajes de Contacto"},
     *     summary="Actualizar mensaje de contacto",
     *     description="Actualiza los datos de un mensaje de contacto existente. Solo es necesario enviar los campos que se desean modificar",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del mensaje de contacto a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del mensaje de contacto a actualizar (solo incluir los campos que se desean modificar)",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="nombre_apellidos",
     *                     type="string",
     *                     description="Nombre completo de la persona que contacta",
     *                     example="Juan Carlos García López"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     format="email",
     *                     description="Dirección de correo electrónico",
     *                     example="juan.garcia.actualizado@ejemplo.com"
     *                 ),
     *                 @OA\Property(
     *                     property="telefono",
     *                     type="string",
     *                     description="Número de teléfono de contacto",
     *                     example="+34 612 345 999"
     *                 ),
     *                 @OA\Property(
     *                     property="mensaje",
     *                     type="string",
     *                     description="Contenido del mensaje de contacto actualizado",
     *                     example="Mensaje actualizado con nueva información..."
     *                 )
     *             ),
     *             example={
     *                 "email": "juan.garcia.actualizado@ejemplo.com",
     *                 "telefono": "+34 612 345 999"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mensaje de contacto actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Mensaje de contacto con ID: 1 actualizado correctamente."),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre_apellidos", type="string", example="Juan Carlos García López"),
     *                 @OA\Property(property="email", type="string", example="juan.garcia.actualizado@ejemplo.com"),
     *                 @OA\Property(property="telefono", type="string", example="+34 612 345 999"),
     *                 @OA\Property(property="mensaje", type="string", example="Hola, me gustaría obtener más información sobre sus servicios..."),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-10T17:15:00.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error de validación."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(property="nombre_apellidos", type="array", @OA\Items(type="string", example="El nombre y apellidos debe ser texto válido.")),
     *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="El email debe tener un formato válido.")),
     *                 @OA\Property(property="telefono", type="array", @OA\Items(type="string", example="El teléfono debe ser texto válido.")),
     *                 @OA\Property(property="mensaje", type="array", @OA\Items(type="string", example="El mensaje debe ser texto válido."))
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mensaje de contacto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Mensaje de contacto con ID: 1 no encontrado")
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
    public function update(Request $request, string $id)
    {
        try {
            $mensajeContacto = MensajesContacto::findOrFail($id);

            $validatedData = $request->validate(
                [
                    'nombre_apellidos' => 'sometimes|string|max:255',
                    'email' => 'sometimes|email|max:255',
                    'telefono' => 'sometimes|string|max:20',
                    'mensaje' => 'sometimes|string|max:1000',
                ],
                [
                    'nombre_apellidos.string' => 'El nombre y apellidos debe ser texto válido.',
                    'nombre_apellidos.max' => 'El nombre y apellidos no puede exceder los 255 caracteres.',

                    'email.email' => 'El email debe tener un formato válido.',
                    'email.max' => 'El email no puede exceder los 255 caracteres.',

                    'telefono.string' => 'El teléfono debe ser texto válido.',
                    'telefono.max' => 'El teléfono no puede exceder los 20 caracteres.',

                    'mensaje.string' => 'El mensaje debe ser texto válido.',
                    'mensaje.max' => 'El mensaje no puede exceder los 1000 caracteres.',
                ]
            );

            $mensajeContacto->update($validatedData);

            return response()->json([
                'message' => 'Mensaje de contacto con ID: ' . $id . ' actualizado correctamente.',
                'data' => $mensajeContacto
            ], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'Mensaje de contacto con ID: ' . $id . ' no encontrado'], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación.',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json(['message' => 'Error al actualizar mensaje de contacto: ', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/mensajes-contacto/{id}",
     *     tags={"Mensajes de Contacto"},
     *     summary="Eliminar mensaje de contacto",
     *     description="Elimina un mensaje de contacto del sistema de forma permanente",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del mensaje de contacto a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Mensaje de contacto eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Mensaje de contacto con ID: 1 borrado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Mensaje de contacto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Mensaje de contacto con ID: 1 no encontrado")
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
            $mensajeContacto = MensajesContacto::findOrFail($id);
            $mensajeContacto->delete();

            return response()->json(['message' => 'Mensaje de contacto con ID: ' . $id . ' borrado correctamente'], 200);
        } catch (ModelNotFoundException) {

            return response()->json(['error' => 'Mensaje de contacto con ID: ' . $id . ' no encontrado'], 404);
        }
    }
}
