<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class FilterProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_products_by_category(): void
    {
        $category = Category::factory()->create();
        $category2 = Category::factory()->create();

        Product::factory()->create(['category_id' => $category->id]);
        Product::factory()->create(['category_id' => $category2->id]);

        $response = $this->get("shop?category=$category->slug");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 1)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('category_id', 1)
                            ->etc();
                    });
            });
    }

    public function test_filter_products_by_multiple_categories(): void
    {
        $category = Category::factory()->create();
        $category2 = Category::factory()->create();

        Product::factory()->create(['category_id' => $category->id]);
        Product::factory()->create(['category_id' => $category2->id]);

        $response = $this->get("shop?category=$category->slug,$category2->slug");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 2);
            });
    }

    public function test_filter_products_by_min_price(): void
    {
        Category::factory()->create();
        Product::factory()->create(['price' => '9.90']);
        Product::factory()->create(['price' => '11.00']);

        $response = $this->get("shop?min_price=10");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 1)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('price', '11.00')
                            ->etc();
                    });
            });
    }

    public function test_filter_products_by_max_price(): void
    {
        Category::factory()->create();
        Product::factory()->create(['price' => '9.90']);
        Product::factory()->create(['price' => '11.00']);

        $response = $this->get("shop?max_price=10");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 1)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('price', '9.90')
                            ->etc();
                    });
            });
    }

    public function test_filter_products_by_min_and_max_price(): void
    {
        Category::factory()->create();

        Product::factory()->create(['price' => '8.00']);
        Product::factory()->create(['price' => '10.00']);
        Product::factory()->create(['price' => '12.00']);

        $response = $this->get("shop?min_price=9&max_price=11");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 1)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('price', '10.00')
                            ->etc();
                    });
            });
    }

    public function test_filter_products_by_searching_their_name(): void
    {
        Category::factory()->create();

        Product::factory()->create(['name' => 'item1']);
        Product::factory()->create(['name' => 'test']);

        $response = $this->get("shop?search=item");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 1)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('name', 'item1')
                            ->etc();
                    });
            });
    }
}
