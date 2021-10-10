<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    /**
     * get orders
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getOrders(Request $request): AnonymousResourceCollection
    {
        $orders = (new OrderService())->getOrdersWithSearchAndFilter($request);
        return OrderResource::collection($orders);
    }

    /**
     * Order Status update
     *
     * @param Order $order
     * @param $status
     * @return JsonResponse
     */
    public function orderStatusUpdate(Order $order, $status): JsonResponse
    {
        $order->status = $status;
        $order->save();
        if ($status != 'Pending') {
            $history = $order->orderStatusHistory
                ?: new OrderStatusHistory();

            $history->{strtolower($status)} = Carbon::now()->toDateString();
            $order->orderStatusHistory()->save($history);
        }
        return Helper::returnResponse("success", "Order Status update successfully", $order);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return OrderResource
     */
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }
}
