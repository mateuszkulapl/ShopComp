<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Group;
use App\Models\Image;
use App\Models\Price;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            GroupSeeder::class,
            ProductSeeder::class,
            ShopSeeder::class,
            PriceSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class
        ]);


        // $groups=Group::factory()
        // ->has(Product::factory()->count(3))
        // ->count(5)
        // ->create();


        /*
        create 100 groups 5 shops, 500 products total,
        each product has 365 prices
        each product has 2 images
        each product has/belongs to 3 categories
        */
        $shops = Shop::factory()->count(5)->create();
        $groups = Group::factory()->count(100)->create();


        foreach ($shops as $shop) {
            $categories = null;
            $categories = Category::factory()->count(5)->create(
                ['shop_id' => $shop->id]
            );
            $categories->get(2)->parent_id = $categories->get(1)->id;
            $categories->get(1)->parent_id = $categories->get(0)->id;
            foreach ($groups as $group) {
                $p = Product::factory()
                    ->count(1)
                    ->for($group)
                    ->for($shop)
                    ->has(Price::factory()->count(20))
                    ->has(Image::factory()->count(2))
                    //->has(Category::factory()->count(1))
                    ->create();

                $p->first()->categories()->attach($categories->random(2)->pluck('id')->toArray()); //attach two random categories belongs to that shop
            }
        }
    }
}
