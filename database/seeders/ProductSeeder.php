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
        Product::create(['name' => 'Pão de forma', 'description' => 'pão branco em fatias','price' => 4.50, 'image' => 'images/Z3nRSYD95cdtZZcNV3qehhjptYRO5yRLsojKpnAH.jpg']);
        Product::create(['name' => 'Pão caseiro', 'description' => 'pão branco macio','price' => 4.50, 'image' => 'images/b1XBRvo8qVAwfG4INPbzjTQQHwmHlzhRkFHqnrFH.jpg']);
        Product::create(['name' => 'Brioche', 'description' => 'pão super macio','price' => 12.00, 'image' => 'images/F5GdxLtZA1TMnVqVCyuzD8SCQ7EKMAdY2hLNp3ey.jpg']);
    }

}
