<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class PerformanceTest extends TestCase
{
    /** @test */
    public function test_cart_page_load_time()
    {
        $startTime = microtime(true);
        
        $response = $this->get('/cart');
        
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        $response->assertStatus(200);
        $this->assertLessThan(2, $loadTime, "Carregamento da página do carrinho demorou mais de 2 segundos.");
    }

    /** @test */
    public function test_checkout_page_load_time()
    {
        // Simula um usuário autenticado
        $this->actingAs(User::factory()->create());

        $startTime = microtime(true);
        
        $response = $this->get('/cart/checkout');
        
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        $response->assertStatus(500);
        $this->assertLessThan(2, $loadTime, "Carregamento da página de checkout demorou mais de 2 segundos.");
    }

    /** @test */
    public function test_orders_page_load_time()
    {
        // Simula um usuário autenticado
        $this->actingAs(User::factory()->create());

        $startTime = microtime(true);
        
        $response = $this->get('/pedidos');
        
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        $response->assertStatus(200);
        $this->assertLessThan(2, $loadTime, "Carregamento da página de pedidos demorou mais de 2 segundos.");
    }
}