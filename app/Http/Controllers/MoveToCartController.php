<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoveToCartController extends Controller
{
    public function __invoke($id)
    {
        $productInCart = auth()->user()->cart->firstWhere('id', $id);

        $productInCart->pivot->saved_for_later = false;
        $productInCart->pivot->save();
    }
}
