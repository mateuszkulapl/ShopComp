<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'parent_id' => null,
            'name' => fake()->words(rand(1,4), true),
            'url' => fake()->url(),
            'shop_unique_cat_key'=>fake()->unique()->slug(),
        ];
    }
}
