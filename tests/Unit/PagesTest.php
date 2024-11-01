<?php

namespace Tests\Unit;

use Tests\TestCase; 
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\CartController;
use Illuminate\Http\Request;
use App\Models\User;

class PagesTest extends TestCase
{
    use RefreshDatabase; 

    protected $cartController;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cartController = new CartController();
    }

    /** @test */
    public function it_can_add_item_to_cart()
    {
        $request = new Request();
        $request->merge(['id' => 7]); //  ID = 7

        Session::start();
        $response = $this->cartController->add($request, 7);

        // Verifique se a sessão tem o item
        $this->assertTrue(Session::has('cart'));
        $this->assertEquals(1, Session::get('cart')[7]); // Verifica se o item foi adicionado
        $this->assertEquals('Item adicionado ao carrinho!', session('success'));
    }

    /** @test */
    public function it_can_decrease_item_quantity_in_cart()
    {
        Session::put('cart', [7 => 2]); // item com quantidade 2

        $request = new Request();
        $response = $this->cartController->decrease(7); // Corrigido para usar o ID correto

        $this->assertEquals(1, Session::get('cart')[7]); // Verifica se a quantidade foi reduzida
        $this->assertEquals('Quantidade reduzida no carrinho.', session('success'));
    }

    /** @test */
    public function it_can_remove_item_from_cart()
    {
        Session::put('cart', [7 => 1]); // um item no carrinho

        $request = new Request();
        $response = $this->cartController->remove(7); // Corrigido para usar o ID correto

        $this->assertArrayNotHasKey(7, Session::get('cart')); // Verifica se o item foi removido
        $this->assertEquals('Item removido do carrinho.', session('success'));
    }

    /** @test */
    public function it_redirects_to_login_if_not_authenticated_on_checkout()
    {
        $response = $this->cartController->checkout(); // Chama o método checkout

        $this->assertEquals(302, $response->getStatusCode()); 
        $this->assertEquals(route('login'), $response->headers->get('Location')); // Verifica o redirecionamento
        $this->assertEquals('Você precisa estar logado para finalizar a compra!', session('error'));
    }

    /** @test */
    public function it_can_access_checkout_if_authenticated()
    {
        // Simula um usuário autenticado
        $this->actingAs(User::factory()->create());

        $response = $this->cartController->checkout();

        // Verifica se a view correta é retornada
        $this->assertEquals('cart.checkout', $response->getName());
    }
}