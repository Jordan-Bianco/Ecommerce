<?php

namespace Tests\Feature\Cart;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ViewCartProductsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_guest_cannot_view_his_cart_products()
    {
        $response = $this->get('/cart');

        $response->assertRedirect('login');
    }

    public function test_auth_user_can_view_his_cart_products()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create());

        auth()->user()->cart()
            ->attach($product->id, ['quantity' => 1]);

        $response = $this->get('/cart');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Cart')
                    ->has('products', 1)
                    ->has('savedProducts', 0);
            });
    }

    public function test_auth_user_can_view_his_cart_products_that_are_in_the_saved_for_later_list()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create());

        auth()->user()->cart()->attach($product->id, ['quantity' => 1]);

        $cartProduct = auth()->user()->cart()->first();

        $this->post("cart/$cartProduct->id/save-for-later");

        $response = $this->get('/cart');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Cart')
                    ->has('products', 0)
                    ->has('savedProducts', 1);
            });
    }
}
