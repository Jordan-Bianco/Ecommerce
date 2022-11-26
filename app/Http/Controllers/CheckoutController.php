<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function store()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));

        $products = Cart::getContent();

        $lineItems = [];

        foreach ($products as $product) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount_decimal' => str_replace('.', '', $product->price),
                ],
                'quantity' => $product->pivot->quantity
            ];
        }

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'shipping_address_collection' => ['allowed_countries' => ['IT']],
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => ['amount' => 0, 'currency' => 'eur'],
                        'display_name' => 'Free shipping',
                        'delivery_estimate' => [
                            'minimum' => ['unit' => 'business_day', 'value' => 5],
                            'maximum' => ['unit' => 'business_day', 'value' => 7],
                        ],
                    ],
                ],
            ],
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'success_url' => route('checkout.success', [], true) . "?checkout_session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.failure', [], true),
            'metadata' => [
                'user_id'  => auth()->user()->id,
            ],
        ]);

        return Inertia::location($checkout_session->url);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->get('checkout_session_id'));
            $customer = \Stripe\Customer::retrieve($checkout_session->customer);

            if (!$checkout_session) {
                return inertia('Checkout/Failure');
            }

            $order = Order::query()
                ->where('stripe_session_id', $checkout_session->id)
                ->first();

            if (!$order) {
                return inertia('Error', ['code' => 404, 'message' => 'Not found']);
            }

            return inertia('Checkout/Success', [
                'customer' => $customer,
                'order' => $order->load('products', 'detail')
            ]);
        } catch (\Exception $e) {
            return inertia('Error', ['code' => 404, 'message' => 'Not found']);
        }
    }

    public function failure(Request $request)
    {
        return inertia('Checkout/Failure');
    }

    public function webhook()
    {
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $this->saveOrder($paymentIntent);
            default:
                echo 'Received unknown event type ' . $event->type;
        }
    }

    /**
     * @param Object $paymentIntent
     * @return bool
     */
    protected function saveOrder($paymentIntent): bool
    {
        $stripe_session_id = $paymentIntent->id;
        $user = User::find($paymentIntent->metadata->user_id);
        $products = $user->cart;
        $total = Cart::getCartTotal($products);

        Log::info(print_r($paymentIntent->shipping, true));

        return DB::transaction(function () use ($total, $user, $products, $stripe_session_id, $paymentIntent) {

            /** Create the order record */
            $order = new Order();
            $order->user_id = $user->id;
            $order->status = OrderStatus::Paid;
            $order->total = $total;
            $order->stripe_session_id = $stripe_session_id;
            $order->save();

            /** Create the payment record */
            $payment = new Payment();
            $payment->user_id = $user->id;
            $payment->order_id = $order->id;
            $payment->status = paymentStatus::Paid;
            $payment->total_amount = $total;
            $payment->stripe_session_id = $stripe_session_id;
            $payment->type = 'card';
            $payment->save();

            /** Create the order_product records */
            foreach ($products as $product) {
                $order->products()->attach($product->id, [
                    'quantity' => $product->pivot->quantity,
                    'unit_price' => $product->price
                ]);
            }

            /** Create the order_details records */
            $order->detail()->create([
                'customer_name' => $paymentIntent->shipping->name,
                'customer_email' => $paymentIntent->customer_details->email,
                'customer_phone' => $paymentIntent->customer_details->phone,
                'country' => $paymentIntent->customer_details->address->country,
                'city' => $paymentIntent->customer_details->address->city,
                'postalcode' => $paymentIntent->customer_details->address->postal_code,
                'province' => $paymentIntent->customer_details->address->state ?? null,
                'address1' => $paymentIntent->customer_details->address->line1,
                'address2' => $paymentIntent->customer_details->address->line2,
            ]);

            /** Empty the cart */
            $user->cart()->detach();

            return true;
        });
    }
}
