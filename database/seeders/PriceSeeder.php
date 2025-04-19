<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::query()
            ->whereDoesntHave('prices')
            ->each(function (Product $product) {
                Price::factory()
                    ->for($product)
                    ->count(rand(1, 20))
                    ->create();
            });
    }
}
