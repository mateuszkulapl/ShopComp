<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'shop_id' => Shop::factory(),
            'group_id' => Group::factory(),
            'title' => fake()->words(rand(1, 8), true) . ' ' . fake()->company(),
            'url' => fake()->url()
        ];
    }
}
