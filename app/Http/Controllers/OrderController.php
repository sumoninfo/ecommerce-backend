<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Order::query();
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        $query = $query->latest()->paginate($request->get('per_page', config('constant.mrhPagination')));
        return OrderResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $order = (new OrderService())->placeAnOrder($request);
        return Helper::returnResponse("success", "Order Created successfully", $order);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Order $order
     * @return OrderResource
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
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