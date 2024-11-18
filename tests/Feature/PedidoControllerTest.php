<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PedidoControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function it_creates_a_order_with_valid_data()
    {
        
        $user = User::factory()->create();
        Auth::login($user);

        // Cria um produto para o pedido
        $product = Product::factory()->create(['price' => 100]);

        
        Session::put('cart', [$product->id => 2]); 

        $response = $this->post('/pedidos', [
            'rua' => 'Rua Teste',
            'numero' => 123,
            'cep' => '12345-678',
            'estado' => 'SP',
            'cidade' => 'São Paulo',
            'complemento' => 'Apto 1',
            'forma_pagamento' => 'cartão',
        ]);

        // Verifica se o pedido foi criado no banco de dados
        $this->assertDatabaseHas('pedidos', [
            'user_id' => $user->id,
            'valor' => 200, 
        ]);

        
        $response->assertRedirect(route('pedidos.index'));
        $response->assertSessionHas('success', 'Pedido realizado com sucesso!');
    }

    
    public function it_fails_to_create_order_with_empty_cart()
    {
        
        $user = User::factory()->create();
        Auth::login($user);

        // Tenta criar um pedido com o carrinho vazio
        $response = $this->post('/pedidos', [
            'rua' => 'Rua Teste',
            'numero' => 123,
            'cep' => '12345-678',
            'estado' => 'SP',
            'cidade' => 'São Paulo',
            'complemento' => 'Apto 1',
            'forma_pagamento' => 'cartão',
        ]);

        
        $response->assertRedirect()->withErrors(['error' => 'Carrinho vazio!']);
    }

    
    public function it_fails_to_create_order_with_invalid_address_data()
    {
        
        $user = User::factory()->create();
        Auth::login($user);

        
        $product = Product::factory()->create(['price' => 100]);
        Session::put('cart', [$product->id => 2]); 

        // Tenta criar um pedido com dados de endereço inválidos
        $response = $this->post('/pedidos', [
            'rua' => '', // Campo obrigatório
            'numero' => 'abc', // Deve ser um número
            'cep' => 'invalid-cep', // Formato inválido
            'estado' => 'SP',
            'cidade' => 'São Paulo',
            'complemento' => 'Apto 1',
            'forma_pagamento' => 'cartão',
        ]);

       
        $this->assertDatabaseMissing('pedidos', [
            'user_id' => $user->id,
        ]);

        //mensagens de erro
        $response->assertSessionHasErrors(['rua', 'numero', 'cep']);
    }
}
