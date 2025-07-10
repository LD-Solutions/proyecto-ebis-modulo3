<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PortfolioController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $portfolios = Portfolio::where('id_usuario', $user->id)
                              ->orderBy('symbol')
                              ->get();
        
        return response()->json($portfolios);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:10|uppercase',
            'shares' => 'required|numeric|min:0.01',
            'purchase_price' => 'required|numeric|min:0.01'
        ]);
        
        $validated['id_usuario'] = $request->user()->id;
        
        $portfolio = Portfolio::create($validated);
        
        return response()->json($portfolio, 201);
    }

    public function show(Request $request, string $id)
    {
        $user = $request->user();
        $portfolio = Portfolio::where('id_usuario', $user->id)
                             ->findOrFail($id);
        
        return response()->json($portfolio);
    }

    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $portfolio = Portfolio::where('id_usuario', $user->id)
                             ->findOrFail($id);
        
        $validated = $request->validate([
            'symbol' => 'sometimes|required|string|max:10|uppercase',
            'shares' => 'sometimes|required|numeric|min:0.01',
            'purchase_price' => 'sometimes|required|numeric|min:0.01'
        ]);
        
        $portfolio->update($validated);
        
        return response()->json($portfolio);
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        $portfolio = Portfolio::where('id_usuario', $user->id)
                             ->findOrFail($id);
        
        $portfolio->delete();
        
        return response()->json(null, 204);
    }
}
