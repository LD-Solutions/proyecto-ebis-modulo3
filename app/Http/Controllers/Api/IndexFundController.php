<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IndexFund;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class IndexFundController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        $query = IndexFund::query();
        
        if ($request->has('symbol')) {
            $query->where('symbol', 'like', '%' . $request->symbol . '%');
        }
        
        $perPage = min($request->get('per_page', 10), 50);
        
        return $query->orderBy('name')
                    ->paginate($perPage);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10|unique:index_funds,symbol|uppercase',
            'expense_ratio' => 'required|numeric|min:0|max:1',
            'aum' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);
        
        $indexFund = IndexFund::create($validated);
        
        return response()->json($indexFund, 201);
    }

    public function show(string $id)
    {
        $indexFund = IndexFund::findOrFail($id);
        
        return response()->json($indexFund);
    }

    public function update(Request $request, string $id)
    {
        $indexFund = IndexFund::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'symbol' => 'sometimes|required|string|max:10|uppercase|unique:index_funds,symbol,' . $id,
            'expense_ratio' => 'sometimes|required|numeric|min:0|max:1',
            'aum' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string'
        ]);
        
        $indexFund->update($validated);
        
        return response()->json($indexFund);
    }

    public function destroy(string $id)
    {
        $indexFund = IndexFund::findOrFail($id);
        $indexFund->delete();
        
        return response()->json(null, 204);
    }
}
