<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NoticiasController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/noticias",
     *     summary="Listar todas las noticias",
     *     description="Obtener lista paginada de noticias publicadas",
     *     tags={"Noticias"},
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
     *         name="categoria",
     *         in="query",
     *         description="Filtrar por categoría",
     *         required=false,
     *         @OA\Schema(type="string", example="tecnologia")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de noticias",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="titulo", type="string", example="Título de la noticia"),
     *                 @OA\Property(property="contenido", type="string", example="Contenido de la noticia..."),
     *                 @OA\Property(property="autor", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="categoria", type="string", example="tecnologia"),
     *                 @OA\Property(property="imagen_url", type="string", example="https://example.com/image.jpg"),
     *                 @OA\Property(property="fecha_publicacion", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *                 @OA\Property(property="publicado", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Noticia::where('publicado', true);
        
        if ($request->has('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        $perPage = min($request->get('per_page', 10), 50);
        
        return $query->orderBy('fecha_publicacion', 'desc')
                    ->paginate($perPage);
    }

    /**
     * @OA\Post(
     *     path="/api/noticias",
     *     summary="Crear nueva noticia",
     *     description="Crear una nueva noticia (requiere autenticación)",
     *     tags={"Noticias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"titulo","contenido","autor","categoria"},
     *             @OA\Property(property="titulo", type="string", example="Nueva noticia importante"),
     *             @OA\Property(property="contenido", type="string", example="Contenido completo de la noticia..."),
     *             @OA\Property(property="autor", type="string", example="Juan Pérez"),
     *             @OA\Property(property="categoria", type="string", example="tecnologia"),
     *             @OA\Property(property="imagen_url", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *             @OA\Property(property="publicado", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Noticia creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="titulo", type="string", example="Nueva noticia importante"),
     *             @OA\Property(property="contenido", type="string", example="Contenido completo de la noticia..."),
     *             @OA\Property(property="autor", type="string", example="Juan Pérez"),
     *             @OA\Property(property="categoria", type="string", example="tecnologia"),
     *             @OA\Property(property="imagen_url", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *             @OA\Property(property="publicado", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Errores de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
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
            'contenido' => 'required|string',
            'autor' => 'required|string|max:255',
            'categoria' => 'required|string|max:100',
            'imagen_url' => 'nullable|url',
            'fecha_publicacion' => 'nullable|date',
            'publicado' => 'boolean'
        ]);
        
        $validated['fecha_publicacion'] = $validated['fecha_publicacion'] ?? now();
        $validated['publicado'] = $validated['publicado'] ?? true;
        
        $noticia = Noticia::create($validated);
        
        return response()->json($noticia, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/noticias/{id}",
     *     summary="Mostrar noticia específica",
     *     description="Obtener detalles de una noticia específica",
     *     tags={"Noticias"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la noticia",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la noticia",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="titulo", type="string", example="Título de la noticia"),
     *             @OA\Property(property="contenido", type="string", example="Contenido completo de la noticia..."),
     *             @OA\Property(property="autor", type="string", example="Juan Pérez"),
     *             @OA\Property(property="categoria", type="string", example="tecnologia"),
     *             @OA\Property(property="imagen_url", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *             @OA\Property(property="publicado", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Noticia no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Noticia no encontrada")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $noticia = Noticia::where('publicado', true)->findOrFail($id);
        
        return response()->json($noticia);
    }

    /**
     * @OA\Put(
     *     path="/api/noticias/{id}",
     *     summary="Actualizar noticia",
     *     description="Actualizar una noticia existente (requiere autenticación)",
     *     tags={"Noticias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la noticia",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="titulo", type="string", example="Título actualizado"),
     *             @OA\Property(property="contenido", type="string", example="Contenido actualizado..."),
     *             @OA\Property(property="autor", type="string", example="Juan Pérez"),
     *             @OA\Property(property="categoria", type="string", example="tecnologia"),
     *             @OA\Property(property="imagen_url", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *             @OA\Property(property="publicado", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Noticia actualizada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="titulo", type="string", example="Título actualizado"),
     *             @OA\Property(property="contenido", type="string", example="Contenido actualizado..."),
     *             @OA\Property(property="autor", type="string", example="Juan Pérez"),
     *             @OA\Property(property="categoria", type="string", example="tecnologia"),
     *             @OA\Property(property="imagen_url", type="string", example="https://example.com/image.jpg"),
     *             @OA\Property(property="fecha_publicacion", type="string", format="date-time", example="2024-01-15T10:30:00Z"),
     *             @OA\Property(property="publicado", type="boolean", example=true),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Noticia no encontrada"
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
        $noticia = Noticia::findOrFail($id);
        
        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'contenido' => 'sometimes|required|string',
            'autor' => 'sometimes|required|string|max:255',
            'categoria' => 'sometimes|required|string|max:100',
            'imagen_url' => 'nullable|url',
            'fecha_publicacion' => 'nullable|date',
            'publicado' => 'boolean'
        ]);
        
        $noticia->update($validated);
        
        return response()->json($noticia);
    }

    /**
     * @OA\Delete(
     *     path="/api/noticias/{id}",
     *     summary="Eliminar noticia",
     *     description="Eliminar una noticia existente (requiere autenticación)",
     *     tags={"Noticias"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la noticia",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Noticia eliminada exitosamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Noticia no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Noticia no encontrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $noticia = Noticia::findOrFail($id);
        $noticia->delete();
        
        return response()->json(null, 204);
    }
}
