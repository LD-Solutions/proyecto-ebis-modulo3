<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PortfolioResource;
use App\Http\Resources\IndexFundResource;
use App\Models\IndexFund;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

/**
 * @OA\Tag(
 *     name="Portfolio",
 *     description="Gestión de portafolio de inversiones"
 * )
 */

class PortfolioController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:sanctum'),
        ];
    }

    /**
     * @OA\Get(
     *     path="/api/portfolios",
     *     tags={"Portfolio"},
     *     summary="Obtener resumen del portafolio del usuario",
     *     description="Retorna el balance, valor total del portafolio, inversión total, ganancia/pérdida y todas las posiciones del usuario autenticado",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Resumen del portafolio obtenido exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="balance", type="number", format="float", example=8500.00, description="Balance disponible del usuario"),
     *             @OA\Property(property="total_portfolio_value", type="number", format="float", example=1520.00, description="Valor total actual del portafolio"),
     *             @OA\Property(property="total_invested", type="number", format="float", example=1500.00, description="Total invertido"),
     *             @OA\Property(property="total_profit_loss", type="number", format="float", example=20.00, description="Ganancia o pérdida total"),
     *             @OA\Property(
     *                 property="holdings",
     *                 type="array",
     *                 description="Lista de posiciones en el portafolio",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="symbol", type="string", example="VTIAX"),
     *                     @OA\Property(property="shares", type="number", format="float", example=10.50),
     *                     @OA\Property(property="purchase_price", type="number", format="float", example=142.86),
     *                     @OA\Property(property="current_value", type="number", format="float", example=1520.00),
     *                     @OA\Property(property="profit_loss", type="number", format="float", example=20.00),
     *                     @OA\Property(
     *                         property="index_fund",
     *                         type="object",
     *                         @OA\Property(property="name", type="string", example="Vanguard Total International Stock Index Fund"),
     *                         @OA\Property(property="symbol", type="string", example="VTIAX"),
     *                         @OA\Property(property="current_price", type="number", format="float", example=144.76)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $portfolios = Portfolio::with(['indexFund', 'user'])
                              ->where('id_usuario', $user->id)
                              ->orderBy('symbol')
                              ->get();
        
        $totalValue = $portfolios->sum('current_value');
        $totalInvested = $portfolios->sum(fn($p) => $p->shares * $p->purchase_price);
        $totalProfitLoss = $totalValue - $totalInvested;
        
        return response()->json([
            'balance' => $user->balance,
            'total_portfolio_value' => $totalValue,
            'total_invested' => $totalInvested,
            'total_profit_loss' => $totalProfitLoss,
            'holdings' => PortfolioResource::collection($portfolios)
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/portfolios",
     *     tags={"Portfolio"},
     *     summary="Comprar posición inicial en un fondo índice",
     *     description="Crea una nueva posición en el portafolio comprando shares de un fondo índice específico",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"symbol", "shares"},
     *             @OA\Property(property="symbol", type="string", maxLength=10, example="tpau", description="Símbolo del fondo índice (case-insensitive)"),
     *             @OA\Property(property="shares", type="number", format="float", minimum=0.01, example=10.5, description="Número de participaciones a comprar")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Posición creada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="symbol", type="string", example="VTIAX"),
     *             @OA\Property(property="shares", type="number", format="float", example=10.50),
     *             @OA\Property(property="purchase_price", type="number", format="float", example=142.86),
     *             @OA\Property(property="id_usuario", type="integer", example=1),
     *             @OA\Property(
     *                 property="index_fund",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Vanguard Total International Stock Index Fund"),
     *                 @OA\Property(property="current_price", type="number", format="float", example=142.86)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Fondos insuficientes o posición ya existe",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Insufficient funds")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de validación incorrectos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'symbol' => 'required|string|max:10',
            'shares' => 'required|numeric|min:0.01'
        ]);
        
        $user = $request->user();
        
        // Find IndexFund case-insensitively
        $indexFund = IndexFund::whereRaw('LOWER(symbol) = LOWER(?)', [$validated['symbol']])->first();
        
        if (!$indexFund) {
            return response()->json(['error' => 'Index fund with symbol "' . $validated['symbol'] . '" not found'], 422);
        }
        
        $totalCost = $validated['shares'] * $indexFund->current_price;
        
        if ($user->balance < $totalCost) {
            return response()->json(['error' => 'Insufficient funds'], 400);
        }
        
        // Check for existing position case-insensitively
        $existingPosition = Portfolio::where('id_usuario', $user->id)
                                   ->whereRaw('LOWER(symbol) = LOWER(?)', [$indexFund->symbol])
                                   ->first();
        
        if ($existingPosition) {
            return response()->json(['error' => 'Position already exists. Use PUT to buy more.'], 400);
        }
        
        $portfolio = Portfolio::create([
            'symbol' => $indexFund->symbol,  // Use the actual symbol from database
            'shares' => $validated['shares'],
            'purchase_price' => $indexFund->current_price,
            'id_usuario' => $user->id
        ]);
        
        $user->update(['balance' => $user->balance - $totalCost]);
        
        return new PortfolioResource($portfolio->load(['indexFund', 'user']));
    }

    /**
     * @OA\Get(
     *     path="/api/portfolios/{id}",
     *     tags={"Portfolio"},
     *     summary="Obtener una posición específica del portafolio",
     *     description="Retorna los detalles de una posición específica en el portafolio del usuario",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la posición en el portafolio"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Posición obtenida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="symbol", type="string", example="VTIAX"),
     *             @OA\Property(property="shares", type="number", format="float", example=10.50),
     *             @OA\Property(property="purchase_price", type="number", format="float", example=142.86),
     *             @OA\Property(property="current_value", type="number", format="float", example=1520.00),
     *             @OA\Property(property="profit_loss", type="number", format="float", example=20.00),
     *             @OA\Property(
     *                 property="index_fund",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Vanguard Total International Stock Index Fund"),
     *                 @OA\Property(property="current_price", type="number", format="float", example=144.76)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Posición no encontrada"
     *     )
     * )
     */
    public function show(Request $request, string $id)
    {
        $user = $request->user();
        $portfolio = Portfolio::with(['indexFund', 'user'])
                             ->where('id_usuario', $user->id)
                             ->findOrFail($id);
        
        return new PortfolioResource($portfolio);
    }

    /**
     * @OA\Put(
     *     path="/api/portfolios/{id}",
     *     tags={"Portfolio"},
     *     summary="Comprar más o vender participaciones de una posición existente",
     *     description="Permite comprar más participaciones o vender parte de una posición existente en el portafolio",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la posición en el portafolio"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"action", "shares"},
     *             @OA\Property(property="action", type="string", enum={"buy", "sell"}, example="buy", description="Acción a realizar: comprar o vender"),
     *             @OA\Property(property="shares", type="number", format="float", minimum=0.01, example=5.0, description="Número de participaciones a comprar/vender")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transacción realizada exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="symbol", type="string", example="VTIAX"),
     *             @OA\Property(property="shares", type="number", format="float", example=15.50),
     *             @OA\Property(property="purchase_price", type="number", format="float", example=143.50),
     *             @OA\Property(
     *                 property="index_fund",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Vanguard Total International Stock Index Fund"),
     *                 @OA\Property(property="current_price", type="number", format="float", example=144.76)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Fondos insuficientes o participaciones insuficientes para vender",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Insufficient funds")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Posición no encontrada"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos de validación incorrectos"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $user = $request->user();
        $portfolio = Portfolio::where('id_usuario', $user->id)
                             ->findOrFail($id);
        
        $validated = $request->validate([
            'action' => 'required|in:buy,sell',
            'shares' => 'required|numeric|min:0.01'
        ]);
        
        $indexFund = IndexFund::where('symbol', $portfolio->symbol)->first();
        
        if (!$indexFund) {
            return response()->json(['error' => 'Index fund not found for this position'], 404);
        }
        $transactionValue = $validated['shares'] * $indexFund->current_price;
        
        if ($validated['action'] === 'buy') {
            if ($user->balance < $transactionValue) {
                return response()->json(['error' => 'Insufficient funds'], 400);
            }
            
            $totalShares = $portfolio->shares + $validated['shares'];
            $weightedPrice = (($portfolio->shares * $portfolio->purchase_price) + 
                            ($validated['shares'] * $indexFund->current_price)) / $totalShares;
            
            $portfolio->update([
                'shares' => $totalShares,
                'purchase_price' => $weightedPrice
            ]);
            
            $user->update(['balance' => $user->balance - $transactionValue]);
            
        } else {
            if ($portfolio->shares < $validated['shares']) {
                return response()->json(['error' => 'Insufficient shares to sell'], 400);
            }
            
            $portfolio->update(['shares' => $portfolio->shares - $validated['shares']]);
            $user->update(['balance' => $user->balance + $transactionValue]);
        }
        
        return new PortfolioResource($portfolio->load(['indexFund', 'user']));
    }

    /**
     * @OA\Delete(
     *     path="/api/portfolios/{id}",
     *     tags={"Portfolio"},
     *     summary="Vender toda la posición",
     *     description="Vende completamente una posición del portafolio y elimina la entrada",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID de la posición en el portafolio"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Posición vendida exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Position sold successfully"),
     *             @OA\Property(property="sale_value", type="number", format="float", example=1520.00, description="Valor total de la venta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Posición no encontrada"
     *     )
     * )
     */
    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        $portfolio = Portfolio::where('id_usuario', $user->id)
                             ->findOrFail($id);
        
        $indexFund = IndexFund::where('symbol', $portfolio->symbol)->first();
        
        if (!$indexFund) {
            return response()->json(['error' => 'Index fund not found for this position'], 404);
        }
        $saleValue = $portfolio->shares * $indexFund->current_price;
        
        $user->update(['balance' => $user->balance + $saleValue]);
        $portfolio->delete();
        
        return response()->json(['message' => 'Position sold successfully', 'sale_value' => $saleValue], 200);
    }
}
