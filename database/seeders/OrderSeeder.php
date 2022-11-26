<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = Product::find(1);
        $product2 = Product::find(2);
        $product3 = Product::find(3);

        $user = User::first();

        /** First order */
        $firstOrder = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'Paid',
            'total' => $product->price,
            'stripe_session_id' => 'test_stripe_session_id'
        ]);

        $firstOrder->products()->attach($product->id, [
            'quantity' => 1,
            'unit_price' => $product->price
        ]);

        $firstOrder->detail()->create([
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => null,
            'country' => 'test country',
            'city' => 'test city',
            'postalcode' => 'test postalcode',
            'address1' => 'test address1',
        ]);

        $firstOrder->payment()->create([
            'user_id' => $user->id,
            'status' => 'Paid',
            'total_amount' => $product->price,
            'stripe_session_id' => 'test_stripe_session_id',
            'type' => 'card'
        ]);

        /** Second order */
        $secondOrder = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'Paid',
            'total' => $product2->price,
            'stripe_session_id' => 'test_stripe_session_id2',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2)
        ]);

        $secondOrder->products()->attach($product2->id, [
            'quantity' => 1,
            'unit_price' => $product2->price,
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2)
        ]);

        $secondOrder->detail()->create([
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => null,
            'country' => 'test country',
            'city' => 'test city',
            'postalcode' => 'test postalcode',
            'address1' => 'test address1',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2)
        ]);

        $secondOrder->payment()->create([
            'user_id' => $user->id,
            'status' => 'Paid',
            'total_amount' => $product2->price,
            'stripe_session_id' => 'test_stripe_session_id2',
            'type' => 'card',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2)
        ]);

        /** Third order */
        $thirdOrder = Order::factory()->create([
            'user_id' => $user->id,
            'status' => 'Paid',
            'total' => $product3->price,
            'stripe_session_id' => 'test_stripe_session_id3',
            'created_at' => Carbon::now()->subDays(30),
            'updated_at' => Carbon::now()->subDays(30)
        ]);

        $thirdOrder->products()->attach($product3->id, [
            'quantity' => 1,
            'unit_price' => $product3->price,
            'created_at' => Carbon::now()->subDays(30),
            'updated_at' => Carbon::now()->subDays(30)
        ]);

        $thirdOrder->detail()->create([
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => null,
            'country' => 'test country',
            'city' => 'test city',
            'postalcode' => 'test postalcode',
            'address1' => 'test address1',
            'created_at' => Carbon::now()->subDays(30),
            'updated_at' => Carbon::now()->subDays(30)
        ]);

        $thirdOrder->payment()->create([
            'user_id' => $user->id,
            'status' => 'Paid',
            'total_amount' => $product3->price,
            'stripe_session_id' => 'test_stripe_session_id3',
            'type' => 'card',
            'created_at' => Carbon::now()->subDays(30),
            'updated_at' => Carbon::now()->subDays(30)
        ]);
    }
}
