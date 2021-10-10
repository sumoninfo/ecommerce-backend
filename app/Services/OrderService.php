<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
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
        $auth  = auth()->user();
        $order = new Order();
        $order->fill($request->all());
        $order->user_id        = $auth->id;
        $order->date           = Carbon::now()->toDateString();
        $order->customer_email = $auth->email;
        $order->save();
        $sub_total          = $this->storeOrderItems($order, $request->carts);
        $order->order_no    = Helper::generateOrderNo($order->id);
        $order->sub_total   = $sub_total;
        $order->grand_total = $sub_total + $request->shipping_cost;
        $order->save();
    }

    /**
     * Store order items
     *
     * @param $order
     * @param $carts
     * @return float|int
     */
    public function storeOrderItems($order, $carts)
    {
        $items = [];
        $total = 0;
        foreach ($carts as $cart) {
            $product   = Product::findOrFail($cart['product_id']);
            $sub_total = $product->price * $cart['quantity'];
            $total     += $sub_total;
            $item      = [
                'product_id' => $product->id,
                'price'      => $product->price,
                'quantity'   => $cart['quantity'],
                'sub_total'  => $sub_total,
            ];
            array_push($items, $item);
        }
        $order->orderItems()->createMany($items);
        return $total;
    }

    /**
     * return orders with searching and filtering
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getOrdersWithSearchAndFilter(Request $request, $type = null)
    {
        $query = Order::query();
        if ($type == 'user') {
            $query->where('user_id', auth()->id());
        }
        if ($request->filled('search')) {
            $query->whereLike(['order_no', 'user.name', 'user.phone', 'user.email'], $request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return $query->latest()->paginate($request->get('per_page', config('constant.mrhPagination')));
    }
}
