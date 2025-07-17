<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Group;
use App\Models\Product;
use App\Models\Price;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Group::truncate();
        Product::truncate();
        Price::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([
            GroupSeeder::class,
            ProductSeeder::class,
            PriceSeeder::class,
        ]);
    }
}
