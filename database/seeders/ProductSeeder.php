<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 'name', 'description', 'price', 'image'
     */
    public function run(): void
    {
        Product::create(['name' => 'Pão de forma', 'description' => 'pão branco em fatias','price' => 4.50, 'image' => 'images/pao_forma.jpg']);
        Product::create(['name' => 'Pão caseiro', 'description' => 'pão branco macio','price' => 4.50, 'image' => 'images/pao-de-forma-caseiro_02.jpg']);
        Product::create(['name' => 'Brioche', 'description' => 'pão super macio','price' => 12.00, 'image' => 'images/pan-brioche-sledibrioche.jpg']);
    }

}
