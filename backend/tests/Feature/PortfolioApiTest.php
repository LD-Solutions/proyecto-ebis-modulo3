<?php

namespace Tests\Feature;

use App\Models\IndexFund;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PortfolioApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected User $user;
    protected IndexFund $indexFund;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create(['balance' => 10000.00]);
        $this->indexFund = IndexFund::factory()->create([
            'symbol' => 'VTIAX',
            'current_price' => 150.00,
            'name' => 'Vanguard Total International Stock Index Fund'
        ]);
    }

    public function test_unauthenticated_user_cannot_access_portfolio(): void
    {
        $response = $this->getJson('/api/portfolios');
        $response->assertStatus(401);
    }

    public function test_can_get_empty_portfolio_summary(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/portfolios');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'balance',
                    'total_portfolio_value',
                    'total_invested',
                    'total_profit_loss',
                    'holdings'
                ])
                ->assertJson([
                    'balance' => 10000.00,
                    'total_portfolio_value' => 0,
                    'total_invested' => 0,
                    'total_profit_loss' => 0,
                    'holdings' => []
                ]);
    }

    public function test_can_buy_initial_position(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/portfolios', [
            'symbol' => 'VTIAX',
            'shares' => 10.0
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'symbol',
                        'shares',
                        'purchase_price',
                        'current_value',
                        'profit_loss',
                        'user' => [
                            'name',
                            'email'
                        ],
                        'index_fund' => [
                            'id',
                            'name',
                            'symbol',
                            'current_price',
                            'description'
                        ]
                    ]
                ])
                ->assertJson([
                    'data' => [
                        'symbol' => 'VTIAX',
                        'shares' => 10.0,
                        'purchase_price' => 150.00,
                        'user' => [
                            'name' => $this->user->name,
                            'email' => $this->user->email
                        ]
                    ]
                ]);

        $this->user->refresh();
        $this->assertEquals(8500.00, $this->user->balance);
        $this->assertDatabaseHas('portfolios', [
            'symbol' => 'VTIAX',
            'shares' => 10.0,
            'id_usuario' => $this->user->id
        ]);
    }

    public function test_cannot_buy_with_insufficient_funds(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/portfolios', [
            'symbol' => 'VTIAX',
            'shares' => 100.0  // Would cost $15,000, user only has $10,000
        ]);

        $response->assertStatus(400)
                ->assertJson(['error' => 'Insufficient funds']);
    }

    public function test_cannot_buy_nonexistent_index_fund(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/portfolios', [
            'symbol' => 'FAKE',
            'shares' => 10.0
        ]);

        $response->assertStatus(422)
                ->assertJson(['error' => 'Index fund with symbol "FAKE" not found']);
    }

    public function test_cannot_create_duplicate_position(): void
    {
        Sanctum::actingAs($this->user);

        // Create initial position
        $this->postJson('/api/portfolios', [
            'symbol' => 'VTIAX',
            'shares' => 5.0
        ]);

        // Try to create another position with same symbol
        $response = $this->postJson('/api/portfolios', [
            'symbol' => 'VTIAX',
            'shares' => 5.0
        ]);

        $response->assertStatus(400)
                ->assertJson(['error' => 'Position already exists. Use PUT to buy more.']);
    }

    public function test_can_get_portfolio_with_positions(): void
    {
        Sanctum::actingAs($this->user);

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->getJson('/api/portfolios');

        $response->assertStatus(200)
                ->assertJsonPath('total_portfolio_value', 1500)  // 10 * 150
                ->assertJsonPath('total_invested', 1400)  // 10 * 140
                ->assertJsonPath('total_profit_loss', 100)  // 1500 - 1400
                ->assertJsonCount(1, 'holdings');
    }

    public function test_can_get_specific_portfolio_position(): void
    {
        Sanctum::actingAs($this->user);

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->getJson("/api/portfolios/{$portfolio->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id' => $portfolio->id,
                        'symbol' => 'VTIAX',
                        'shares' => 10.0,
                        'purchase_price' => 140.00
                    ]
                ]);
    }

    public function test_cannot_access_other_users_portfolio(): void
    {
        $otherUser = User::factory()->create();
        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $otherUser->id,
            'symbol' => 'VTIAX'
        ]);

        Sanctum::actingAs($this->user);

        $response = $this->getJson("/api/portfolios/{$portfolio->id}");
        $response->assertStatus(404);
    }

    public function test_can_buy_more_shares(): void
    {
        Sanctum::actingAs($this->user);

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->putJson("/api/portfolios/{$portfolio->id}", [
            'action' => 'buy',
            'shares' => 5.0
        ]);

        $response->assertStatus(200);
        
        $portfolio->refresh();
        $this->assertEquals(15.0, $portfolio->shares);
        
        // Check weighted average price: (10*140 + 5*150) / 15 = 143.33
        $this->assertEqualsWithDelta(143.33, $portfolio->purchase_price, 0.01);
        
        $this->user->refresh();
        $this->assertEquals(9250.00, $this->user->balance);  // 10000 - 750 (5*150)
    }

    public function test_can_sell_some_shares(): void
    {
        Sanctum::actingAs($this->user);
        $this->user->update(['balance' => 8500.00]);  // Simulate already spent money

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->putJson("/api/portfolios/{$portfolio->id}", [
            'action' => 'sell',
            'shares' => 3.0
        ]);

        $response->assertStatus(200);
        
        $portfolio->refresh();
        $this->assertEquals(7.0, $portfolio->shares);
        
        $this->user->refresh();
        $this->assertEquals(8950.00, $this->user->balance);  // 8500 + 450 (3*150)
    }

    public function test_cannot_sell_more_shares_than_owned(): void
    {
        Sanctum::actingAs($this->user);

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 5.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->putJson("/api/portfolios/{$portfolio->id}", [
            'action' => 'sell',
            'shares' => 10.0
        ]);

        $response->assertStatus(400)
                ->assertJson(['error' => 'Insufficient shares to sell']);
    }

    public function test_cannot_buy_more_with_insufficient_funds(): void
    {
        Sanctum::actingAs($this->user);
        $this->user->update(['balance' => 100.00]);  // Very low balance

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 5.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->putJson("/api/portfolios/{$portfolio->id}", [
            'action' => 'buy',
            'shares' => 10.0  // Would cost $1500
        ]);

        $response->assertStatus(400)
                ->assertJson(['error' => 'Insufficient funds']);
    }

    public function test_can_sell_entire_position(): void
    {
        Sanctum::actingAs($this->user);
        $this->user->update(['balance' => 8500.00]);  // Simulate already spent money

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->deleteJson("/api/portfolios/{$portfolio->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Position sold successfully',
                    'sale_value' => 1500.00  // 10 * 150
                ]);

        $this->user->refresh();
        $this->assertEquals(10000.00, $this->user->balance);  // 8500 + 1500

        $this->assertDatabaseMissing('portfolios', [
            'id' => $portfolio->id
        ]);
    }

    public function test_portfolio_calculates_current_value_correctly(): void
    {
        Sanctum::actingAs($this->user);

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0,
            'purchase_price' => 140.00
        ]);

        $response = $this->getJson("/api/portfolios/{$portfolio->id}");

        $response->assertStatus(200)
                ->assertJsonPath('data.current_value', 1500)  // 10 * 150 (current price)
                ->assertJsonPath('data.profit_loss', 100);   // 1500 - (10 * 140)
    }

    public function test_requires_valid_action_for_update(): void
    {
        Sanctum::actingAs($this->user);

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0
        ]);

        $response = $this->putJson("/api/portfolios/{$portfolio->id}", [
            'action' => 'invalid_action',
            'shares' => 5.0
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['action']);
    }

    public function test_requires_minimum_shares_for_transactions(): void
    {
        Sanctum::actingAs($this->user);

        // Test store with invalid shares
        $response = $this->postJson('/api/portfolios', [
            'symbol' => 'VTIAX',
            'shares' => 0  // Below minimum
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['shares']);

        $portfolio = Portfolio::factory()->create([
            'id_usuario' => $this->user->id,
            'symbol' => 'VTIAX',
            'shares' => 10.0
        ]);

        // Test update with invalid shares
        $response = $this->putJson("/api/portfolios/{$portfolio->id}", [
            'action' => 'buy',
            'shares' => -1  // Negative shares
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['shares']);
    }
}