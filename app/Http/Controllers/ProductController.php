<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        return inertia('Product/Show', [
            'product' => new ProductResource($product->load('category'))
        ]);
    }
}
