<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class WhishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_add_product_to_whishlist()
    {
        $this->post('/whishlist/1')
            ->assertRedirect('/login');
    }

    public function test_user_can_add_product_to_whishlist()
    {
        Category::factory()->create();
        Product::factory(2)->create();

        $this->actingAs(User::factory()->create());

        $this->post('/whishlist/2');

        $this->assertDatabaseHas('whishlists', [
            'user_id' => 1,
            'product_id' => 2,
        ]);
    }

    public function test_if_product_is_already_present_in_the_whishlist_it_is_removed()
    {
        Category::factory()->create();
        Product::factory(2)->create();

        $this->actingAs(User::factory()->create());

        $this->post('/whishlist/2');

        $this->assertDatabaseHas('whishlists', [
            'user_id' => 1,
            'product_id' => 2,
        ]);

        $this->post('/whishlist/2');

        $this->assertDatabaseMissing('whishlists', [
            'user_id' => 1,
            'product_id' => 2,
        ]);
    }

    public function test_user_can_view_his_whishlist()
    {
        Category::factory()->create();
        Product::factory(1)->create();

        $this->actingAs(User::factory()->create());

        auth()->user()->whishlist()->attach(1);

        $this->get('whishlist')
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Whishlist')
                    ->has('products', 1);
            });
    }

    public function test_user_can_empty_his_whishlist()
    {
        Category::factory()->create();
        Product::factory(2)->create();

        $this->actingAs(User::factory()->create());

        auth()->user()->whishlist()->attach(1);
        auth()->user()->whishlist()->attach(2);

        $this->assertDatabaseCount('whishlists', 2);

        $this->delete('/whishlist');

        $this->assertDatabaseCount('whishlists', 0);
    }

    public function test_user_can_move_a_product_from_whishlist_to_cart()
    {
        Category::factory()->create();
        Product::factory()->create();

        $this->actingAs(User::factory()->create());

        auth()->user()->whishlist()->attach(1);

        $this->assertDatabaseCount('whishlists', 1);

        $this->post('/whishlist/1/move-to-cart');

        $this->assertDatabaseCount('whishlists', 0);
        $this->assertDatabaseHas('carts', [
            'user_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'saved_for_later' => false,
        ]);
    }
}
