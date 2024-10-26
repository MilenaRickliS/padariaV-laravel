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
        // usuário autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        //  adicionar um item ao carrinho
        $response = $this->post('/cart/add/7'); // ID = 7

        // Verifica se o item foi adicionado à sessão
        $this->assertTrue(Session::has('cart'));
        $this->assertEquals(1, Session::get('cart')[7]); 


        $response->assertSessionHas('success', 'Item adicionado ao carrinho!');
    }

    /** @test */
    public function it_can_remove_item_from_cart()
    {
        // usuário autenticado
        $user = User::factory()->create();
        $this->actingAs($user);

        // Adiciona um item ao carrinho
        Session::put('cart', [7 => 1]); 

        // remover o item do carrinho
        $response = $this->get('/cart/remove/7');

        // Verifica se o item foi removido da sessão
        $this->assertArrayNotHasKey(7, Session::get('cart')); 

    
        $response->assertSessionHas('success', 'Item removido do carrinho.');
    }
}