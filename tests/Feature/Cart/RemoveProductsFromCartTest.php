<?php

namespace Tests\Feature\Cart;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveProductsFromCartTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_guest_cannot_remove_products_from_cart()
    {
        $response = $this->delete('/cart/1');

        $response->assertRedirect('login');
    }

    public function test_auth_user_can_remove_products_from_his_cart()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create());

        $this->post("/cart/$product->id");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);

        $this->delete("/cart/$product->id");

        $this->assertDatabaseMissing('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);

        $this->assertDatabaseCount('carts', 0);
    }

    public function test_auth_user_can_empty_his_cart()
    {
        Product::factory(2)->create();

        $this->actingAs(User::factory()->create());

        $this->post("/cart/1");
        $this->post("/cart/2");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 1
        ]);

        $this->delete('/cart/empty');

        $this->assertDatabaseMissing('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1
        ]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 1
        ]);
    }

    public function test_when_auth_user_empties_the_card_the_products_saved_for_later_remain()
    {
        Product::factory(2)->create();

        $this->actingAs(User::factory()->create());

        // User add 2 products to cart
        $this->post("/cart/1");
        $this->post("/cart/2");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'saved_for_later' => false
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 1,
            'saved_for_later' => false
        ]);

        // User save 1 product to save for later list
        $this->post("cart/1/save-for-later");

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'saved_for_later' => true
        ]);

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 1,
            'saved_for_later' => false
        ]);

        $this->delete('/cart/empty');

        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'saved_for_later' => true
        ]);

        $this->assertDatabaseMissing('carts', [
            'user_id' => 1,
            'product_id' => 2,
            'quantity' => 1,
            'saved_for_later' => false
        ]);
    }
}
