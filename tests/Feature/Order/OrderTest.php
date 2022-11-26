<?php

namespace Tests\Feature\Order;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function setup(): void
    {
        parent::setUp();

        $user = User::factory()->create()->first();
        $this->actingAs($user);

        Category::factory()->create();

        Product::factory()->create([
            'price' => '10.00',
            'available_quantity' => 2
        ]);

        auth()->user()->cart()->attach(1, ['quantity' => 2]);
    }

    public function test_user_is_redirected_to_strie_checkout()
    {
        $this->post('/checkout')
            ->assertStatus(302);
    }
}
