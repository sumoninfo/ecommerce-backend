<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'products' => Product::count(),
            'customers' => User::count(),
            'orders' => User::count(),
        ]);
    }
}
