<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Group;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GroupSeeder::class,
            ShopSeeder::class,
            ProductSeeder::class,
            PriceSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class
        ]);
    }
}
