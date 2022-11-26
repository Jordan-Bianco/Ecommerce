<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Whishlist;

class WhishlistController extends Controller
{
    public function index()
    {
        return inertia('Whishlist', [
            'products' => Whishlist::getContent()
        ]);
    }

    public function toggle(Product $product)
    {
        Whishlist::toggle($product);
    }

    public function moveToCart(Product $product)
    {
        Whishlist::moveToCart($product);
    }

    public function destroy()
    {
        Whishlist::empty();
    }
}
