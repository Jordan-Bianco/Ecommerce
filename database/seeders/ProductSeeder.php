<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $sneakers = Product::factory(3)->create(['category_id' => 1]);
        $boots = Product::factory(2)->create(['category_id' => 2]);
        $shorts = Product::factory(1)->create(['category_id' => 3]);
        $jeans = Product::factory(4)->create(['category_id' => 4]);
        $shirts = Product::factory(2)->create(['category_id' => 5]);
        $hoodies = Product::factory(2)->create(['category_id' => 6]);
        $sweatshirts = Product::factory(4)->create(['category_id' => 7]);
        $hats = Product::factory(5)->create(['category_id' => 8]);

        foreach ($shirts as $shirt) {
            $shirt->images()->create(['url' => 'green-shirt.jpg']);
        }

        foreach ($sneakers as $sneaker) {
            $sneaker->images()->create(['url' => 'sneaker.jpg']);
        }

        foreach ($boots as $boot) {
            $boot->images()->create(['url' => 'boot.jpg']);
        }

        foreach ($shorts as $short) {
            $short->images()->create(['url' => 'short.jpg']);
        }

        foreach ($jeans as $j) {
            $j->images()->create(['url' => 'jeans.jpg']);
        }

        foreach ($hoodies as $hoodie) {
            $hoodie->images()->create(['url' => 'hoodie.jpg']);
        }

        foreach ($sweatshirts as $sweatshirt) {
            $sweatshirt->images()->create(['url' => 'sweatshirt.jpg']);
        }

        foreach ($hats as $hat) {
            $hat->images()->create(['url' => 'hat.jpg']);
        }
    }
}
