<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Formacion;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FormacionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/formaciones",
     *     summary="Listar contenido de formación",
     *     description="Obtener lista paginada de cursos, videos, libros y webinars",
     *     tags={"Formación"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Número de página",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Elementos por página (máximo 50)",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="tipo",
     *         in="query",
     *         description="Filtrar por tipo de contenido",
     *         required=false,
     *         @OA\Schema(type="string", enum={"curso", "video", "libro", "webinar"}, example="libro")
     *     ),
     *     @OA\Parameter(
     *         name="categoria",
     *         in="query",
     *         description="Filtrar por categoría",
     *         required=false,
     *         @OA\Schema(type="string", example="finanzas")
     *     ),
     *     @OA\Parameter(
     *         name="nivel",
     *         in="query",
     *         description="Filtrar por nivel",
     *         required=false,
     *         @OA\Schema(type="string", enum={"principiante", "intermedio", "avanzado"}, example="principiante")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de contenido de formación",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="titulo", type="string", example="Introducción a las Inversiones"),
     *                 @OA\Property(property="descripcion", type="string", example="Curso básico sobre inversiones..."),
     *                 @OA\Property(property="instructor", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="precio", type="number", format="float", example=99.99),
     *                 @OA\Property(property="tipo", type="string", enum={"curso", "video", "libro", "webinar"}, example="curso"),
     *                 @OA\Property(property="categoria", type="string", example="finanzas"),
     *                 @OA\Property(property="nivel", type="string", enum={"principiante", "intermedio", "avanzado"}, example="principiante"),
     *                 @OA\Property(property="duracion_horas", type="integer", example=20, nullable=true),
     *                 @OA\Property(property="fecha_inicio", type="string", format="date-time", example="2024-01-15T10:30:00Z", nullable=true),
     *                 @OA\Property(property="archivo_path", type="string", example="libros/introduccion-inversiones.txt", nullable=true),
     *                 @OA\Property(property="paginas", type="integer", example=150, nullable=true),
     *                 @OA\Property(property="url_video", type="string", example="https://youtube.com/watch?v=abc123", nullable=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )),
     *             @OA\Property(property="links", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="total", type="integer", example=25),
     *             @OA\Property(property="per_page", type="integer", example=10),
     *             @OA\Property(property="current_page", type="integer", example=1)
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Formacion::query();
        
        if ($request->has('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        if ($request->has('nivel')) {
            $query->where('nivel', $request->nivel);
        }
        
        if ($request->has('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        $perPage = min($request->get('per_page', 10), 50);
        
        return $query->orderBy('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * @OA\Post(
     *     path="/api/formaciones",
     *     summary="Crear contenido de formación",
     *     description="Crear nuevo curso, video, libro o webinar (requiere autenticación)",
     *     tags={"Formación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo","descripcion","instructor","precio","tipo","categoria","nivel"},
     *             @OA\Property(property="titulo", type="string", example="Curso de Trading Avanzado"),
     *             @OA\Property(property="descripcion", type="string", example="Aprende estrategias avanzadas de trading..."),
     *             @OA\Property(property="instructor", type="string", example="Ana García"),
     *             @OA\Property(property="precio", type="number", format="float", example=149.99),
     *             @OA\Property(property="tipo", type="string", enum={"curso", "video", "libro", "webinar"}, example="curso"),
     *             @OA\Property(property="categoria", type="string", example="trading"),
     *             @OA\Property(property="nivel", type="string", enum={"principiante", "intermedio", "avanzado"}, example="avanzado"),
     *             @OA\Property(property="duracion_horas", type="integer", example=25, nullable=true),
     *             @OA\Property(property="fecha_inicio", type="string", format="date-time", example="2024-02-01T09:00:00Z", nullable=true),
     *             @OA\Property(property="archivo_path", type="string", example="libros/trading-avanzado.pdf", nullable=true),
     *             @OA\Property(property="paginas", type="integer", example=200, nullable=true),
     *             @OA\Property(property="url_video", type="string", example="https://youtube.com/watch?v=xyz789", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contenido de formación creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="titulo", type="string", example="Curso de Trading Avanzado"),
     *             @OA\Property(property="descripcion", type="string", example="Aprende estrategias avanzadas..."),
     *             @OA\Property(property="instructor", type="string", example="Ana García"),
     *             @OA\Property(property="precio", type="number", format="float", example=149.99),
     *             @OA\Property(property="tipo", type="string", example="curso"),
     *             @OA\Property(property="categoria", type="string", example="trading"),
     *             @OA\Property(property="nivel", type="string", example="avanzado"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'instructor' => 'required|string|max:255',
            'duracion_horas' => 'nullable|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'tipo' => 'required|in:curso,video,libro,webinar',
            'categoria' => 'required|string|max:100',
            'nivel' => 'required|in:principiante,intermedio,avanzado',
            'fecha_inicio' => 'nullable|date',
            'archivo_path' => 'nullable|string',
            'paginas' => 'nullable|integer|min:1',
            'url_video' => 'nullable|url'
        ]);
        
        $formacion = Formacion::create($validated);
        
        return response()->json($formacion, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/formaciones/{id}",
     *     summary="Mostrar contenido de formación específico",
     *     description="Obtener detalles de un curso, video, libro o webinar específico",
     *     tags={"Formación"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del contenido de formación",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del contenido de formación",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="titulo", type="string", example="Introducción a las Criptomonedas"),
     *             @OA\Property(property="descripcion", type="string", example="Guía completa sobre el mundo de las criptomonedas..."),
     *             @OA\Property(property="instructor", type="string", example="Carlos López"),
     *             @OA\Property(property="precio", type="number", format="float", example=29.99),
     *             @OA\Property(property="tipo", type="string", example="libro"),
     *             @OA\Property(property="categoria", type="string", example="criptomonedas"),
     *             @OA\Property(property="nivel", type="string", example="principiante"),
     *             @OA\Property(property="archivo_path", type="string", example="libros/criptomonedas-guia-completa.txt"),
     *             @OA\Property(property="paginas", type="integer", example=180),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contenido de formación no encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        $formacion = Formacion::findOrFail($id);
        
        return response()->json($formacion);
    }

    /**
     * @OA\Put(
     *     path="/api/formaciones/{id}",
     *     summary="Actualizar contenido de formación",
     *     description="Actualizar curso, video, libro o webinar existente (requiere autenticación)",
     *     tags={"Formación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del contenido de formación",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="titulo", type="string", example="Curso de Trading Actualizado"),
     *             @OA\Property(property="precio", type="number", format="float", example=199.99),
     *             @OA\Property(property="nivel", type="string", enum={"principiante", "intermedio", "avanzado"}, example="intermedio")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contenido de formación actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="titulo", type="string", example="Curso de Trading Actualizado"),
     *             @OA\Property(property="precio", type="number", format="float", example=199.99),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contenido de formación no encontrado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $formacion = Formacion::findOrFail($id);
        
        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'instructor' => 'sometimes|required|string|max:255',
            'duracion_horas' => 'sometimes|nullable|integer|min:1',
            'precio' => 'sometimes|required|numeric|min:0',
            'tipo' => 'sometimes|required|in:curso,video,libro,webinar',
            'categoria' => 'sometimes|required|string|max:100',
            'nivel' => 'sometimes|required|in:principiante,intermedio,avanzado',
            'fecha_inicio' => 'sometimes|nullable|date',
            'archivo_path' => 'sometimes|nullable|string',
            'paginas' => 'sometimes|nullable|integer|min:1',
            'url_video' => 'sometimes|nullable|url'
        ]);
        
        $formacion->update($validated);
        
        return response()->json($formacion);
    }

    /**
     * @OA\Delete(
     *     path="/api/formaciones/{id}",
     *     summary="Eliminar contenido de formación",
     *     description="Eliminar un curso, video, libro o webinar existente (requiere autenticación)",
     *     tags={"Formación"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del contenido de formación",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Contenido de formación eliminado exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contenido de formación no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $formacion = Formacion::findOrFail($id);
        $formacion->delete();
        
        return response()->json(null, 204);
    }
}
