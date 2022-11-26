<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function setup(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_return_all_products_whose_available_quantity_is_above_0(): void
    {
        Product::factory(2)->create();
        Product::factory()->create(['available_quantity' => 0]);

        $response = $this->get('/shop');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 2)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('id', Product::first()->id)
                            ->etc();
                    });
            });
    }

    public function test_return_all_categories()
    {
        Product::factory(2)->create();

        $response = $this->get('/shop');

        $response
            ->assertStatus(200)
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->has('products.data', 2)
                    ->has('categories', 1);
            });
    }
}
