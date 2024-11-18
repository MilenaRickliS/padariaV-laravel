<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    
    public function it_registers_a_user_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@hotmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

       
        $this->assertDatabaseHas('users', [
            'email' => 'test@hotmail.com',
        ]);

        
        $response->assertRedirect('/');
    }

    
    public function it_fails_to_register_a_user_with_invalid_email()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Verifica se o usuário não foi criado no banco de dados
        $this->assertDatabaseMissing('users', [
            'email' => 'invalid-email',
        ]);

       
        $response->assertSessionHasErrors('email');
    }

    
    public function it_fails_to_register_a_user_with_short_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@hotmail.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        // Verifica se o usuário não foi criado no banco de dados
        $this->assertDatabaseMissing('users', [
            'email' => 'test@hotmail.com',
        ]);

        
        $response->assertSessionHasErrors('password');
    }

    
    public function it_fails_to_register_a_user_with_mismatched_password_confirmation()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@hotmail.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpassword',
        ]);

        // Verifica se o usuário não foi criado no banco de dados
        $this->assertDatabaseMissing('users', [
            'email' => 'test@hotmail.com',
        ]);

        
        $response->assertSessionHasErrors('password');
    }

    
    public function it_fails_to_register_a_user_with_invalid_name()
    {
        $response = $this->post('/register', [
            'name' => 'Invalid Name 123!',
            'email' => 'test@hotmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Verifica se o usuário não foi criado no banco de dados
        $this->assertDatabaseMissing('users', [
            'email' => 'test@hotmail.com',
        ]);

       
        $response->assertSessionHasErrors('name');
    }
}
