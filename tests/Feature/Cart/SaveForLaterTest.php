<?php

namespace Tests\Feature\Cart;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaveForLaterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_cart_product_can_be_moved_from_cart_to_save_for_later_list()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create());

        auth()->user()->cart()
            ->attach($product->id, ['quantity' => 1]);

        $cartProduct = auth()->user()->cart()->first();

        $this->assertFalse($cartProduct->pivot->saved_for_later);

        $this->post("cart/$cartProduct->id/save-for-later");

        $this->assertTrue($cartProduct->pivot->fresh()->saved_for_later);
    }

    public function test_cart_product_can_be_moved_from_save_for_later_list_to_cart()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create());

        auth()->user()->cart()
            ->attach($product->id, ['quantity' => 1]);

        $cartProduct = auth()->user()->cart()->first();

        $this->assertFalse($cartProduct->pivot->saved_for_later);

        $this->post("cart/$cartProduct->id/save-for-later");

        $this->assertTrue($cartProduct->pivot->fresh()->saved_for_later);

        $this->post("cart/$cartProduct->id/move-to-cart");

        $this->assertFalse($cartProduct->pivot->saved_for_later);
    }

    public function test_when_product_is_moved_to_the_save_for_later_list_its_quantity_is_reset_to_1()
    {
        $product = Product::factory()->create();
        $this->actingAs(User::factory()->create());

        auth()->user()->cart()
            ->attach($product->id, ['quantity' => 2]);

        $cartProduct = auth()->user()->cart()->first();

        $this->post("cart/$cartProduct->id/save-for-later");

        $this->assertEquals(1, $cartProduct->pivot->fresh()->quantity);
    }
}
