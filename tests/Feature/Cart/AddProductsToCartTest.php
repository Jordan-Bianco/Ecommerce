<?php

namespace Tests\Feature\Cart;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddProductsToCartTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_guest_cannot_add_products_to_his_cart()
    {
        $response = $this->post('/cart/1');

        $response->assertRedirect('login');
    }

    public function test_auth_user_can_add_products_to_his_cart()
    {
        $this->actingAs(User::factory()->create());

        Product::factory(2)->create();

        $this->post('/cart/1');

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);
    }

    public function test_if_product_is_already_in_the_cart_update_its_quantity()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create(['available_quantity' => 2]);

        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }

    public function test_if_the_quantity_the_user_wants_is_not_available_return_error_message()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create(['available_quantity' => 2]);

        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => $product->id,
            'quantity' => 1
        ]);

        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => $product->id,
            'quantity' => 2
        ]);

        $this->post("/cart/$product->id")
            ->assertSessionHas('error', 'The selected quantity is not available at the moment.');


        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }
}
