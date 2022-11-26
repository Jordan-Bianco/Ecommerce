<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Whishlist extends Pivot
{
    protected $table = 'whishlists';

    /**
     * @param Product $product
     * @return void
     */
    public static function toggle(Product $product): void
    {
        $productInWhishlist = auth()->user()->whishlist()
            ->wherePivot('product_id', $product->id)
            ->first();

        if (!$productInWhishlist) {
            auth()->user()->whishlist()->attach($product->id);
        } else {
            auth()->user()->whishlist()->detach($product->id);
        }
    }

    public static function getContent(): Collection
    {
        return auth()->user()->whishlist;
    }

    /**
     * @param Product $product
     * @return void
     */
    public static function moveToCart(Product $product): void
    {
        auth()->user()->cart()->attach($product->id, ['quantity' => 1]);
        auth()->user()->whishlist()->detach($product->id);
    }

    public static function empty(): void
    {
        auth()->user()->whishlist()->detach();
    }
}
