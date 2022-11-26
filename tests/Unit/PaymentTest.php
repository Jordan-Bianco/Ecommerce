<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_payment_belongs_to_user()
    {
        $payment = Payment::factory()->create();

        $this->assertInstanceOf(User::class, $payment->user);
    }

    public function test_payment_belongs_to_order()
    {
        $payment = Payment::factory()->create();

        $this->assertInstanceOf(Order::class, $payment->order);
    }
}
