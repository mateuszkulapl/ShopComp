<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'url' => $this->faker->imageUrl($this->faker->numberBetween(100, 800), $this->faker->numberBetween(100, 800))
        ];
    }
}
