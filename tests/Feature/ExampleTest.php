<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function test_login_page_is_accessible()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_register_page_is_accessible()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }


    /** @test */
    public function test_cart_page_is_accessible_when_authenticated()
    {
        // Simula um usuário autenticado
        $this->actingAs(User::factory()->create());

        $response = $this->get('/cart');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_checkout_page_is_accessible_when_authenticated()
    {
        // Simula um usuário autenticado
        $this->actingAs(User::factory()->create());

        $response = $this->get('/cart/checkout');
        $response->assertStatus(500);
    }

    /** @test */
    public function test_orders_page_is_accessible_when_authenticated()
    {
        // Simula um usuário autenticado
        $this->actingAs(User::factory()->create());

        $response = $this->get('/pedidos');
        $response->assertStatus(200);
    }
}
