<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\BookingRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Delivery;
use App\Models\Order;
use App\Services\BookingService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $orders = (new BookingService())->getOrdersWithSearchAndFilter($request, 'user');
        return OrderResource::collection($orders);
    }

    /**
     * Get delivered orders.
     *
     * @return AnonymousResourceCollection
     */
    public function deliveredOrders(Request $request)
    {
        $orders = (new BookingService())->getDeliveredOrdersWithSearchAndFilter($request, 'user');
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(BookingRequest $request)
    {
       return $order = (new BookingService())->storeBooking($request);
        try {
            return Helper::returnResponse("success", "Order Created successfully", $order);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return OrderResource
     */
    public function show($id, Request $request)
    {
        $order = Order::find($id);
        if ($request->type == 'delivered') {
            $order = Delivery::find($id);
        }
        return new OrderResource($order->where('user_id', auth()->id())->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Order $order)
    {
        $order->fill($request->all());
        $order->update();
        return Helper::returnResponse("success", "Updated successfully", $order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return Helper::returnResponse("success", "Deleted successfully");
    }
}
