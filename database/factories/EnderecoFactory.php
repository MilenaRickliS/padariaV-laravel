<?php

namespace Database\Factories;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    protected $model = Endereco::class;

    public function definition()
    {
        return [
            'pedido_id' => \App\Models\Pedido::factory(), // Cria um pedido automaticamente
            'rua' => $this->faker->streetAddress,
            'numero' => $this->faker->buildingNumber,
            'cep' => $this->faker->postcode,
            'cidade' => $this->faker->city,
            'complemento' => $this->faker->optional()->word, // Opcional
            'forma_pagamento' => $this->faker->randomElement(['pix', 'cartao', 'dinheiro']), // Exemplo de opções
        ];
    }
}