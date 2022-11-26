<?php

namespace Tests\Feature\Cart;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTotalTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_cart_total()
    {
        Category::factory()->create();

        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create(['price' => 20.10]);
        $product2 = Product::factory()->create(['price' => 40.60]);

        auth()->user()->cart()->attach($product->id, ['quantity' => 1]);
        auth()->user()->cart()->attach($product2->id, ['quantity' => 1]);

        $this->assertDatabaseCount('carts', 2);

        $this->assertEquals(60.70, Cart::getCartTotal(auth()->user()->cart));
    }
}
