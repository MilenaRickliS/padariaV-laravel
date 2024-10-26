<?php

namespace Database\Factories;

use App\Models\ItemPedido;
use App\Models\Pedido;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemPedidoFactory extends Factory
{
    protected $model = ItemPedido::class;

    public function definition()
    {
        return [
            'pedido_id' => Pedido::factory(), // Cria um pedido automaticamente
            'product_id' => Product::factory(), // Cria um produto automaticamente
            'quantidade' => $this->faker->numberBetween(1, 10), // Quantidade entre 1 e 10
        ];
    }
}