<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_user_can_place_many_products_in_the_cart()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->cart);
    }
}
