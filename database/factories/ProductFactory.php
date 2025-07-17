<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'id_group' => 1,
        ];
    }
}
