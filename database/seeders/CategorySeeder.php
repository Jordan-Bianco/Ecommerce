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
        Category::factory()->create(['name' => 'Sneakers']);
        Category::factory()->create(['name' => 'Boots']);
        Category::factory()->create(['name' => 'Shorts']);
        Category::factory()->create(['name' => 'Jeans']);
        Category::factory()->create(['name' => 'T-shirt']);
        Category::factory()->create(['name' => 'Hoodie']);
        Category::factory()->create(['name' => 'Sweatshirt']);
        Category::factory()->create(['name' => 'Hats']);
    }
}
