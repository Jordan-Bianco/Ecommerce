<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaveForLaterController extends Controller
{
    public function __invoke($id)
    {
        $productInCart = auth()->user()->cart->firstWhere('id', $id);

        $productInCart->pivot->saved_for_later = true;
        $productInCart->pivot->quantity = 1;
        $productInCart->pivot->save();
    }
}
