<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = OrderResource::collection(
            Order::query()
                ->where('user_id', auth()->id())
                ->with('products', 'detail')
                ->withSortBy($request->sortBy ?? '')
                ->get()
        );

        return inertia('Dashboard/Order', [
            'orders' => $orders
        ]);
    }
}
