<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'rooms'     => Room::count(),
            'customers' => User::count(),
            'bookings'  => Booking::count()
        ]);
    }
}
