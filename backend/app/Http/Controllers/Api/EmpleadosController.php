<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Empleado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;


class EmpleadosController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/empleados",
     *     tags={"Empleados"},
     *     summary="Listar empleados",
     *     description="Obtiene la lista completa de empleados registrados en el sistema",
     *     @OA\Response(
     *         response=200,
     *         description="Listado completo de empleados",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nombre", type="string", example="Juan Carlos"),
     *                 @OA\Property(property="apellido", type="string", example="García López"),
     *                 @OA\Property(property="cargo", type="string", example="Desarrollador Full Stack"),
     *                 @OA\Property(property="imagen_url", type="string", example="https://ejemplo.com/fotos/juan-garcia.jpg"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z")
     *             ),
     *             example={
     *                 {
     *                     "id": 1,
     *                     "nombre": "Juan Carlos",
     *                     "apellido": "García López",
     *                     "cargo": "Desarrollador Full Stack",
     *                     "imagen_url": "https://ejemplo.com/fotos/juan-garcia.jpg",
     *                     "created_at": "2024-01-15T10:30:00.000000Z",
     *                     "updated_at": "2024-01-15T10:30:00.000000Z"
     *                 },
     *                 {
     *                     "id": 2,
     *                     "nombre": "María Elena",
     *                     "apellido": "Rodríguez Pérez",
     *                     "cargo": "Diseñadora UX/UI",
     *                     "imagen_url": "https://ejemplo.com/fotos/maria-rodriguez.jpg",
     *                     "created_at": "2024-01-16T14:25:00.000000Z",
     *                     "updated_at": "2024-01-16T14:25:00.000000Z"
     *                 }
     *             }
     *         )
     *     )
     * )
     */
    public function index()
    {
        $empleados = Empleado::all();

        return response()->json($empleados, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/empleados",
     *     tags={"Empleados"},
     *     summary="Crear empleado",
     *     description="Crea un nuevo empleado en el sistema",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del empleado a crear",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"nombre","apellido","cargo"},
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string",
     *                     description="Nombre del empleado",
     *                     example="Ana Patricia"
     *                 ),
     *                 @OA\Property(
     *                     property="apellido",
     *                     type="string",
     *                     description="Apellido del empleado",
     *                     example="Martínez Silva"
     *                 ),
     *                 @OA\Property(
     *                     property="cargo",
     *                     type="string",
     *                     description="Cargo o rol dentro de la empresa",
     *                     example="Gerente de Proyectos"
     *                 ),
     *                 @OA\Property(
     *                     property="imagen_url",
     *                     type="string",
     *                     format="uri",
     *                     description="URL de la imagen de perfil (opcional)",
     *                     example="https://ejemplo.com/fotos/ana-martinez.jpg"
     *                 )
     *             ),
     *             example={
     *                 "nombre": "Ana Patricia",
     *                 "apellido": "Martínez Silva",
     *                 "cargo": "Gerente de Proyectos",
     *                 "imagen_url": "https://ejemplo.com/fotos/ana-martinez.jpg"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Empleado creado satisfactoriamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=3),
     *             @OA\Property(property="nombre", type="string", example="Ana Patricia"),
     *             @OA\Property(property="apellido", type="string", example="Martínez Silva"),
     *             @OA\Property(property="cargo", type="string", example="Gerente de Proyectos"),
     *             @OA\Property(property="imagen_url", type="string", example="https://ejemplo.com/fotos/ana-martinez.jpg"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-10T16:45:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-10T16:45:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="nombre", type="array", @OA\Items(type="string", example="El campo nombre es obligatorio.")),
     *             @OA\Property(property="apellido", type="array", @OA\Items(type="string", example="El campo apellido es obligatorio.")),
     *             @OA\Property(property="cargo", type="array", @OA\Items(type="string", example="El campo cargo es obligatorio.")),
     *             @OA\Property(property="imagen_url", type="array", @OA\Items(type="string", example="El campo imagen_url debe ser una URL válida."))
     *         )
     *     )
     * )
     **/
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate(
                [
                    'nombre' => 'required|string|max:255',
                    'apellido' => 'required|string|max:255',
                    'cargo' => 'required|string|max:255',
                    'imagen_url' => 'nullable|url',
                ],
                [
                    "nombre.required" => "El campo nombre es obligatorio.",
                    "apellido.required" => "El campo apellido es obligatorio.",
                    "cargo.required" => "El campo cargo es obligatorio.",
                    "nombre.string" => "El campo nombre debe ser texto.",
                    "apellido.string" => "El campo apellido debe ser texto.",
                    "cargo.string" => "El campo cargo debe ser texto.",
                    "nombre.max" => "El campo nombre no puede tener más de 255 caracteres.",
                    "apellido.max" => "El campo apellido no puede tener más de 255 caracteres.",
                    "cargo.max" => "El campo cargo no puede tener más de 255 caracteres.",
                    "imagen_url.url" => "El campo imagen_url debe ser una URL válida.",
                ]
            );

            $empleado = Empleado::create($validatedData);

            return response()->json($empleado, 201);
        } catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/empleados/{id}",
     *     tags={"Empleados"},
     *     summary="Mostrar empleado",
     *     description="Obtiene los detalles de un empleado específico por su ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del empleado a consultar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Juan Carlos"),
     *             @OA\Property(property="apellido", type="string", example="García López"),
     *             @OA\Property(property="cargo", type="string", example="Desarrollador Full Stack"),
     *             @OA\Property(property="imagen_url", type="string", example="https://ejemplo.com/fotos/juan-garcia.jpg"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Empleado no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Empleado no encontrado")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $empleado = Empleado::findOrFail($id);

            return response()->json($empleado, 200);
        } catch (ModelNotFoundException) {

            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/empleados/{id}",
     *     tags={"Empleados"},
     *     summary="Actualizar empleado",
     *     description="Actualiza los datos de un empleado existente. Solo es necesario enviar los campos que se desean modificar",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del empleado a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos del empleado a actualizar (solo incluir los campos que se desean modificar)",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="nombre",
     *                     type="string",
     *                     description="Nombre del empleado",
     *                     example="Juan Carlos"
     *                 ),
     *                 @OA\Property(
     *                     property="apellido",
     *                     type="string",
     *                     description="Apellido del empleado",
     *                     example="García López"
     *                 ),
     *                 @OA\Property(
     *                     property="cargo",
     *                     type="string",
     *                     description="Cargo o rol dentro de la empresa",
     *                     example="Senior Full Stack Developer"
     *                 ),
     *                 @OA\Property(
     *                     property="imagen_url",
     *                     type="string",
     *                     format="uri",
     *                     description="URL de la imagen de perfil",
     *                     example="https://ejemplo.com/fotos/juan-garcia-nuevo.jpg"
     *                 )
     *             ),
     *             example={
     *                 "cargo": "Senior Full Stack Developer",
     *                 "imagen_url": "https://ejemplo.com/fotos/juan-garcia-nuevo.jpg"
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado actualizado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="nombre", type="string", example="Juan Carlos"),
     *             @OA\Property(property="apellido", type="string", example="García López"),
     *             @OA\Property(property="cargo", type="string", example="Senior Full Stack Developer"),
     *             @OA\Property(property="imagen_url", type="string", example="https://ejemplo.com/fotos/juan-garcia-nuevo.jpg"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-15T10:30:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-10T17:15:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación o no se enviaron campos válidos",
     *         @OA\JsonContent(
     *             oneOf={
     *                 @OA\Schema(
     *                     @OA\Property(property="error", type="string", example="Debes enviar al menos un campo correcto para actualizar.")
     *                 ),
     *                 @OA\Schema(
     *                     @OA\Property(property="nombre", type="array", @OA\Items(type="string", example="El campo nombre debe ser texto.")),
     *                     @OA\Property(property="apellido", type="array", @OA\Items(type="string", example="El campo apellido debe ser texto.")),
     *                     @OA\Property(property="cargo", type="array", @OA\Items(type="string", example="El campo cargo debe ser texto.")),
     *                     @OA\Property(property="imagen_url", type="array", @OA\Items(type="string", example="El campo imagen_url debe ser una URL válida."))
     *                 )
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Empleado no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Empleado no encontrado")
     *         )
     *     )
     * )
     */

    public function update(Request $request, string $id)
    {
        try {
            // 1. Buscar
            $empleado = Empleado::findOrFail($id);

            // 2. Validar
            $validatedData = $request->validate(
                [
                    'nombre'      => 'sometimes|filled|string|max:255',
                    'apellido'    => 'sometimes|filled|string|max:255',
                    'cargo'       => 'sometimes|filled|string|max:255',
                    'imagen_url'  => 'sometimes|nullable|url',
                ],
                [
                    'nombre.string'   => 'El campo nombre debe ser texto.',
                    'apellido.string' => 'El campo apellido debe ser texto.',
                    'cargo.string'    => 'El campo cargo debe ser texto.',
                    'nombre.max'      => 'El campo nombre no puede tener más de 255 caracteres.',
                    'apellido.max'    => 'El campo apellido no puede tener más de 255 caracteres.',
                    'cargo.max'       => 'El campo cargo no puede tener más de 255 caracteres.',
                    'imagen_url.url'  => 'El campo imagen_url debe ser una URL válida.',
                ]
            );
        }
        // 3. No existe el ID → 404
        catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Empleado no encontrado'], 404);
        }
        // 4. Validación fallida → 422
        catch (ValidationException $e) {
            return response()->json($e->errors(), 422);
        }

        // 5. Ningún dato válido
        if (empty($validatedData)) {
            return response()->json([
                'error' => 'Debes enviar al menos un campo correcto para actualizar.',
            ], 422);
        }

        // 6. Actualizar
        $empleado->fill($validatedData);
        $empleado->save();

        return response()->json($empleado, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/empleados/{id}",
     *     tags={"Empleados"},
     *     summary="Eliminar empleado",
     *     description="Elimina un empleado del sistema de forma permanente",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del empleado a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Empleado eliminado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Empleado eliminado correctamente")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Empleado no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Empleado no encontrado")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $empleado = Empleado::findOrFail($id);
            $empleado->delete();

            return response()->json(['message' => 'Empleado eliminado correctamente'], 200);
        } catch (ModelNotFoundException) {

            return response()->json(['error' => 'Empleado no encontrado'], 404);
        }
    }
}
