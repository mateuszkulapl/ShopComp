<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::all();
        foreach ($shops as $shop) {
            $num = rand(0, 3);
            $categories = Category::factory()->count($num)->create([
                'shop_id' => $shop->id,
            ]);
            if ($num == 0) {
                continue;
            }
            Category::factory()->count(rand(0, 5))->create([
                'shop_id' => $shop->id,
                'parent_id' => $categories->random()->id,
            ]);
        }
        $products = Product::with('shop.categories')->get();

        $products->each(function (Product $product) {
            if ($product->shop->categories->isEmpty()) {
                return;
            }

            $categoriesToAttach = $product->shop->categories
                ->shuffle()
                ->take(rand(1, 3));

            $product->categories()->attach($categoriesToAttach);
        });
    }
}
