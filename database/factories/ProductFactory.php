<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->sentence(2);
        $slug = Str::slug($name);

        return [
            'category_id' => Category::all()->random()->id,
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomElement(['10.99', '20.10', '29.99', '10.00', '39.90']),
            'available_quantity' => $this->faker->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}
