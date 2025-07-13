<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();
        $products->each(function (Product $product) {
            Image::factory()
                ->for($product)
                ->count(fake()->numberBetween(0, 5))
                ->create();
        });
    }
}
