<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Database\Factories\OrderProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SortProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_sort_products_by_price_desc(): void
    {
        Category::factory()->create();

        Product::factory()->create(['price' => '10.00']);
        Product::factory()->create(['price' => '20.00']);

        $response = $this->get("shop?sortBy=price_desc");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 2)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('price', '20.00')
                            ->etc();
                    })
                    ->has('products.data.1', function (AssertableInertia $page) {
                        $page
                            ->where('price', '10.00')
                            ->etc();
                    });
            });
    }

    public function test_sort_products_by_price_asc(): void
    {
        Category::factory()->create();

        Product::factory()->create(['price' => '20.00']);
        Product::factory()->create(['price' => '10.00']);

        $response = $this->get("shop?sortBy=price_asc");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 2)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('price', '10.00')
                            ->etc();
                    })
                    ->has('products.data.1', function (AssertableInertia $page) {
                        $page
                            ->where('price', '20.00')
                            ->etc();
                    });
            });
    }

    public function test_sort_products_by_most_purchased(): void
    {
        Category::factory()->create();

        Product::factory()->create();
        Product::factory()->create();
        Product::factory()->create();

        Order::factory()->create();
        Order::factory()->create();

        DB::table('order_product')->insert([
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 3,
            'unit_price' => '8.00',
        ]);

        DB::table('order_product')->insert([
            'order_id' => 2,
            'product_id' => 2,
            'quantity' => 5,
            'unit_price' => '10.00',
        ]);

        $response = $this->get("shop?sortBy=best_selling");

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Shop')
                    ->has('products.data', 3)
                    ->has('products.data.0', function (AssertableInertia $page) {
                        $page
                            ->where('id', 2)
                            ->etc();
                    })
                    ->has('products.data.1', function (AssertableInertia $page) {
                        $page
                            ->where('id', 1)
                            ->etc();
                    })
                    ->has('products.data.2', function (AssertableInertia $page) {
                        $page
                            ->where('id', 3)
                            ->etc();
                    });
            });
    }
}
