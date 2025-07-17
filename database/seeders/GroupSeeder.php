<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    public function run(): void
    {
        Group::factory()->count(3)->create()->each(function ($parent) {
            Group::factory()->count(2)->create([
                'id_parent' => $parent->id,
            ]);
        });
    }
}
