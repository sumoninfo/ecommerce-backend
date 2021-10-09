<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

;

class OrderService
{
    /**
     * product search and filter
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function placeAnOrder(Request $request)
    {
        $order = new Order();
        $order->fill($request->all());
        $order->user_id = auth()->id();
        $order->save();
        $order->orderItems()->createMany($request->carts);
    }
}
