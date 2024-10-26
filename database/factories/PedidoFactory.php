<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Cria um usuário automaticamente
            'valor' => $this->faker->randomFloat(2, 10, 1000), // Valor entre 10.00 e 1000.00
        ];
    }
}