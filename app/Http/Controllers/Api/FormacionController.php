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

    public function index(Request $request)
    {
        $query = Formacion::query();
        
        if ($request->has('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        if ($request->has('nivel')) {
            $query->where('nivel', $request->nivel);
        }
        
        $perPage = min($request->get('per_page', 10), 50);
        
        return $query->orderBy('fecha_inicio')
                    ->paginate($perPage);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'instructor' => 'required|string|max:255',
            'duracion_horas' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'nivel' => 'required|in:principiante,intermedio,avanzado',
            'fecha_inicio' => 'required|date|after:now'
        ]);
        
        $formacion = Formacion::create($validated);
        
        return response()->json($formacion, 201);
    }

    public function show(string $id)
    {
        $formacion = Formacion::findOrFail($id);
        
        return response()->json($formacion);
    }

    public function update(Request $request, string $id)
    {
        $formacion = Formacion::findOrFail($id);
        
        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'instructor' => 'sometimes|required|string|max:255',
            'duracion_horas' => 'sometimes|required|integer|min:1',
            'precio' => 'sometimes|required|numeric|min:0',
            'categoria' => 'sometimes|required|string|max:100',
            'nivel' => 'sometimes|required|in:principiante,intermedio,avanzado',
            'fecha_inicio' => 'sometimes|required|date'
        ]);
        
        $formacion->update($validated);
        
        return response()->json($formacion);
    }

    public function destroy(string $id)
    {
        $formacion = Formacion::findOrFail($id);
        $formacion->delete();
        
        return response()->json(null, 204);
    }
}
