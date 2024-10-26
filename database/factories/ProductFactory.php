<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Nome do produto
            'description' => $this->faker->sentence, // Descrição do produto
            'price' => $this->faker->randomFloat(2, 1, 1000), // Preço entre 1.00 e 1000.00
            'image' => $this->faker->imageUrl(640, 480, 'products', true), // URL da imagem
        ];
    }
}