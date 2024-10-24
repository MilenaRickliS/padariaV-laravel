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
        Product::create(['name' => 'Pão de forma', 'description' => 'pão branco em fatias','price' => 4.50, 'image' => 'images/paoforma.png']);
        Product::create(['name' => 'Pão caseiro', 'description' => 'pão branco macio','price' => 4.50, 'image' => 'images/caseiro.png']);
        Product::create(['name' => 'Brioche', 'description' => 'pão super macio','price' => 12.00, 'image' => 'images/brioche.png']);
        Product::create(['name' => 'Pão francês', 'description' => 'pão crocante','price' => 0.5, 'image' => 'images/frances.png']);
        Product::create(['name' => 'Pão Italiano', 'description' => 'pão macio, ideal para sopa','price' => 15.00, 'image' => 'images/italiano.png']);
        Product::create(['name' => 'Pão Integral', 'description' => 'pão preto com grãos','price' => 12.00, 'image' => 'images/integral.png']);
    }

}
