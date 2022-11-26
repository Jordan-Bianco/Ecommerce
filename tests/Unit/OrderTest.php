<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_belongs_to_user()
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(User::class, $order->user);
    }

    public function test_order_belongs_to_many_products()
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(Collection::class, $order->products);
    }
}
