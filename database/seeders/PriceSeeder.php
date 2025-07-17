<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        Product::all()->each(function ($product) {
            Price::create([
                'id_product' => $product->id,
                'price' => fake()->numberBetween(100, 9990),
            ]);
        });
    }
}
