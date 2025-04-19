<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Group;
use App\Models\Image;
use App\Models\Product;
use App\Models\Price;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::factory()
            ->count(fake()->numberBetween(1, 100));
    }
}
