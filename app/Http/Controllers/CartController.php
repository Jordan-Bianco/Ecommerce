<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $products = Cart::getContent();
        $savedProducts = Cart::getContent('saved');
        $total = Cart::getCartTotal($products);

        return inertia('Cart', [
            'products' => $products,
            'savedProducts' => $savedProducts,
            'total' => $total,
        ]);
    }

    public function store(Product $product)
    {
        $productInCart = auth()->user()->cart()
            ->firstWhere('product_id', $product->id);

        if ($productInCart) {
            return $this->increaseQty($productInCart);
        }

        auth()->user()->cart()
            ->attach($product->id, ['quantity' => 1]);

        return back();
    }

    public function increase(Product $product)
    {
        $productInCart = auth()->user()->cart()
            ->firstWhere('product_id', $product->id);

        $this->increaseQty($productInCart);

        return back()->with('success', true);
    }

    public function decrease(Product $product)
    {
        $productInCart = auth()->user()->cart()
            ->firstWhere('product_id', $product->id);

        $this->decreaseQty($productInCart);

        return back()->with('success', true);
    }

    public function destroy(Product $product)
    {
        auth()->user()->cart()
            ->detach(['product_id' => $product->id]);

        return back();
    }

    public function empty()
    {
        Cart::empty();

        return back();
    }

    /**
     * @param Product $productInCart
     * @return void
     */
    protected function increaseQty($productInCart)
    {
        if ($productInCart->available_quantity > $productInCart->pivot->quantity) {
            $productInCart->pivot->quantity = $productInCart->pivot->quantity + 1;
            $productInCart->pivot->save();
        } else {
            return back()->with('error', 'The selected quantity is not available at the moment.');
        }
    }

    /**
     * @param Product $productInCart
     * @return void
     */
    protected function decreaseQty($productInCart)
    {
        if ($productInCart->pivot->quantity === 1) {
            auth()->user()->cart()
                ->detach(['product_id' => $productInCart->pivot->product_id]);

            return;
        }

        $productInCart->pivot->quantity = $productInCart->pivot->quantity - 1;
        $productInCart->pivot->save();
    }
}
