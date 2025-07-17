<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Group;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $groupIds = Group::pluck('id');

        Product::factory()->count(50)->create([
            'id_group' => $groupIds->random()
        ]);
    }
}
