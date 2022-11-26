<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_cart_items()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->cart);
    }

    public function test_user_has_many_whishlist_items()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->whishlist);
    }

    public function test_user_can_make_many_orders()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->orders);
    }

    public function test_user_can_make_many_payments()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->payments);
    }
}
