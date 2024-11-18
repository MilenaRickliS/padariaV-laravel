<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Endereco;

class DatabaseIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_and_store_user()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@hotmail.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Test User',
            'email' => 'test@hotmail.com',
        ]);
    }


    /** @test */
    public function it_can_create_and_store_pedido()
    {
        $user = User::factory()->create();
        $pedido = Pedido::factory()->create([
            'user_id' => $user->id,
            
        ]);

        $this->assertDatabaseHas('pedidos', [
            'id' => $pedido->id,
            'user_id' => $user->id,
            
        ]);
    }

    /** @test */
    public function it_can_create_and_store_item_pedido()
    {
        $product = Product::factory()->create();
        $pedido = Pedido::factory()->create();
        $itemPedido = ItemPedido::factory()->create([
            'pedido_id' => $pedido->id,
            'product_id' => $product->id,
            'quantidade' => 2,
        ]);

        $this->assertDatabaseHas('item_pedidos', [
            'id' => $itemPedido->id,
            'pedido_id' => $pedido->id,
            'product_id' => $product->id,
            'quantidade' => 2,
        ]);
    }

    /** @test */
    public function it_can_create_and_store_endereco()
    {
        $pedido = Pedido::factory()->create();
        $endereco = Endereco::factory()->create([
            'pedido_id' => $pedido->id,
            'rua' => 'Test St',
            'numero' => '12345',
            'cep' => '12345',
            'cidade' => 'Test City',
            'estado' => 'Test',
            'complemento' => 'TS',
            'forma_pagamento' => 'pix',
        ]);

        $this->assertDatabaseHas('enderecos', [
            'id' => $endereco->id,
            'pedido_id' => $pedido->id,
            'rua' => 'Test St',
            'numero' => '12345',
            'cep' => '12345',
            'cidade' => 'Test City',
            'estado' => 'Test',
            'complemento' => 'TS',
            'forma_pagamento' => 'pix',
        ]);
    }

}