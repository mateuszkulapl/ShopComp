<?php

namespace Database\Seeders;

use App\Models\Category;
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
        // $categories=Category::factory()->count(5)->create();
        // $categories2=Category::factory()->count(5)->create(
        //     (function() use ($categories) {
        //         return [
        //             'parent_id' => $categories->random()
        //         ];
        //     })
        // );
    }
}
