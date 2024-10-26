<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_sql_injection_prevention()
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => "' OR '1'='1", // Tentativa de injeção SQL
        ]);

        $response->assertSessionHasErrors(); // Verifica se ocorreu um erro
        $this->assertGuest(); 
    }

    /** @test */
    public function test_xss_prevention()
    {
        $response = $this->post('/register', [
            'name' => '<script>alert("XSS")</script>',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password', 
        ]);

        // Verifica se o usuário não foi criado com o nome malicioso
        $this->assertDatabaseMissing('users', [
            'name' => '<script>alert("XSS")</script>',
        ]);

        // Verifica se houve erro ao tentar registrar
        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function test_protected_route_requires_authentication()
    {
        $response = $this->get('/pedidos');
        $response->assertRedirect('/login'); // Verifica se redireciona para a página de login
    }

    /** @test */
    public function test_authenticated_user_can_access_protected_route()
    {
        $user = User::factory()->create(); // Cria um usuário
        $this->actingAs($user); // Simula o login do usuário

        $response = $this->get('/pedidos');
        $response->assertStatus(200); // Verifica se a página é acessível
    }
}