<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Cart extends Pivot
{
    protected $table = 'carts';

    protected $casts = [
        'saved_for_later' => 'boolean'
    ];

    /**
     * @param ?string $instance
     */
    public static function getContent($instance = null)
    {
        if ($instance && $instance === 'saved') {
            return auth()->user()->cart()
                ->where('saved_for_later', true)
                ->get();
        }

        return auth()->user()->cart()
            ->where('saved_for_later', false)
            ->get();
    }

    /**
     * @param int $id
     */
    public static function getCartTotal($products)
    {
        $total = "0.00";

        foreach ($products as $item) {
            $total += $item->price * $item->pivot->quantity;
        }

        return number_format($total, 2);
    }

    public static function empty()
    {
        $ids = Cart::getContent();

        auth()->user()->cart()
            ->detach($ids->pluck('id'));
    }
}
