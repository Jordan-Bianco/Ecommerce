<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_a_single_product(): void
    {
        Category::factory()->create();

        $product = Product::factory()->create();

        $response = $this->get("/products/$product->slug");

        $response
            ->assertInertia(function (AssertableInertia $page) use ($product) {
                $page
                    ->component('Product/Show')
                    ->has('product', function (AssertableInertia $page) use ($product) {
                        $page
                            ->where('id', $product->id)
                            ->where('name', $product->name)
                            // ->where('name', $product->name) check altri category.name ecc
                            ->etc();
                    });
            });
    }
}
