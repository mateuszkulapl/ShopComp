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
            'title' => self::getFakeTitle(),
            'url' => fake()->url()
        ];
    }

    private static function getFakeTitle()
    {
        return fake()->realText(rand(10, 100), true) .
            (rand(1, 100) <= 75 ? ' ' . fake()->company() : '');
    }
}
