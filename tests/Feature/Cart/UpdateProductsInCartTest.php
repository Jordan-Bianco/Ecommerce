<?php

namespace Tests\Feature\Cart;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateProductsInCartTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_guest_cannot_add_update_his_cart()
    {
        $this->patch('/cart/1/increase')->assertRedirect('login');
        $this->patch('/cart/1/decrease')->assertRedirect('login');
    }

    public function test_auth_user_can_increase_product_quantity()
    {
        $product = Product::factory()->create(['available_quantity' => 2]);
        $this->actingAs(User::factory()->create());

        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);

        $this->patch("/cart/$product->id/increase");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ]);
    }

    public function test_auth_user_can_decrease_product_quantity()
    {
        $product = Product::factory()->create(['available_quantity' => 2]);
        $this->actingAs(User::factory()->create());

        $this->post("/cart/$product->id");
        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ]);

        $this->patch("/cart/$product->id/decrease");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);
    }

    public function test_if_the_quantity_of_an_product_in_the_cart_drops_to_0_the_product_is_removed()
    {
        $product = Product::factory()->create(['available_quantity' => 1]);
        $this->actingAs(User::factory()->create());

        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);

        $this->patch("/cart/$product->id/decrease");

        $this->assertDatabaseMissing('carts', [
            'user_id' => 1,
            'product_id' => 1,
        ]);
    }
}
