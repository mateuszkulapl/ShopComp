<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $current = $this->faker->randomFloat(2, 0.00, 100);
        $old = $this->faker->boolean() ? $this->faker->randomFloat(2, $current + 0.01, 100 + 0.01) : null;
        return [
            'product_id' => Product::factory(),
            'current' => $current,
            'old' => $old,
            'created_at'=>$this->faker->dateTimeBetween('-20 days', now())
        ];
    }
}
