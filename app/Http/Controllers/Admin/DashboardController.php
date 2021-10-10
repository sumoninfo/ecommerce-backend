<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'products'         => Product::count(),
            'customers'        => User::count(),
            'orders'           => Order::count(),
            'delivered_orders' => Delivery::count(),
        ]);
    }
}
