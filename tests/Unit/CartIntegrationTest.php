<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class CartIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_add_item_to_cart_and_store_in_session()
    {
        // Simula um usuário autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        // Simula a requisição para adicionar um item ao carrinho
        $response = $this->post('/cart/add/7'); // Supondo que o ID do produto seja 7

        // Verifica se o item foi adicionado à sessão
        $this->assertTrue(Session::has('cart'));
        $this->assertEquals(1, Session::get('cart')[7]); // Verifica se o item foi adicionado

        // Verifica se a resposta contém a mensagem de sucesso
        $response->assertSessionHas('success', 'Item adicionado ao carrinho!');
    }

    /** @test */
    public function it_can_remove_item_from_cart()
    {
        // Simula um usuário autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        // Adiciona um item ao carrinho
        Session::put('cart', [7 => 1]); // Simula um item no carrinho

        // Simula a requisição para remover o item do carrinho
        $response = $this->get('/cart/remove/7');

        // Verifica se o item foi removido da sessão
        $this->assertArrayNotHasKey(7, Session::get('cart')); // Verifica se o item foi removido

        // Verifica se a resposta contém a mensagem de sucesso
        $response->assertSessionHas('success', 'Item removido do carrinho.');
    }
}