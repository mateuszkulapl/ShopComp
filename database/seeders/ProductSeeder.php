<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shops = Shop::all();
        if ($shops->isEmpty()) {
            $shops = Shop::factory()->count(5)->create();
        }
        $groups = Group::all();
        if ($groups->isEmpty()) {
            $groups = Group::factory()->count(5)->create();
        }
        Product::factory()->count(200)
            ->state(function () use ($shops, $groups) {
                return [
                    //it can create multiple products for same shop, but it's ok for mocking
                    'shop_id' => $shops->random()->id,
                    'group_id' => $groups->random()->id,
                ];
            })
            ->create();
    }
}
