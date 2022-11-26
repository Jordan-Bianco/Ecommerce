<?php

namespace Tests\Feature\Dashboard;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DashboardOrderTest extends TestCase
{
    use RefreshDatabase;

    public function setup(): void
    {
        parent::setUp();

        Category::factory()->create();
    }

    public function test_user_can_view_all_his_orders_with_the_relative_products(): void
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);

        Product::factory()->create();
        Order::factory()->create(['user_id' => $user->id]);

        DB::table('order_product')->insert([
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 1,
            'unit_price' => '10.00',
        ]);

        $response = $this->get('/dashboard/orders');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Dashboard/Order')
                    ->has('orders', 1)
                    ->has('orders.0.products');
            });
    }

    public function test_user_can_sort_his_orders_by_total_amount_desc(): void
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);

        Product::factory()->create(['price' => '10.00']);
        Product::factory()->create(['price' => '20.00']);

        Order::factory()->create([
            'user_id' => $user->id,
            'total' => '10.00'
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'total' => '20.00'
        ]);

        $response = $this->get('/dashboard/orders?sortBy=total_desc');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Dashboard/Order')
                    ->has('orders', 2)
                    ->has('orders.0', function (AssertableInertia $page) {
                        $page
                            ->where('id', 2)
                            ->etc();
                    });
            });
    }

    public function test_user_can_sort_his_orders_by_total_amount_asc(): void
    {
        $user = User::factory()->create()->first();
        $this->actingAs($user);

        Product::factory()->create(['price' => '10.00']);
        Product::factory()->create(['price' => '20.00']);

        Order::factory()->create([
            'user_id' => $user->id,
            'total' => '20.00'
        ]);

        Order::factory()->create([
            'user_id' => $user->id,
            'total' => '10.00'
        ]);

        $response = $this->get('/dashboard/orders?sortBy=total_asc');

        $response
            ->assertInertia(function (AssertableInertia $page) {
                $page
                    ->component('Dashboard/Order')
                    ->has('orders', 2)
                    ->has('orders.0', function (AssertableInertia $page) {
                        $page
                            ->where('id', 2)
                            ->etc();
                    });
            });
    }
}
