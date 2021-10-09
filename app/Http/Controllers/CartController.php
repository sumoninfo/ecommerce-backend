<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Cart::with('product')
            ->orderBy('created_at', 'desc')
            ->get();
        return CartResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $item = Cart::where('product_id', $request->product_id);

        if ($item->count()) {
            $item->increment('quantity');
            $item = $item->first();
        } else {
            $item = Cart::forceCreate([
                'product_id' => $request->product_id,
                'price'      => $request->price,
                'subtotal' => $request->price * 1,
                'quantity'   => 1,
            ]);
        }

        return response()->json([
            'quantity' => $item->quantity,
            'product'  => $item->product,
            'message'  => 'Product added to cart.',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cart $cart
     * @return CartResource
     */
    public function show(Cart $cart)
    {
        return new CartResource($cart);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Cart $cart)
    {
        $cart->fill($request->all());
        $cart->update();
        return Helper::returnResponse("success", "Updated successfully", $cart);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cart $cart
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Cart $cart)
    {
        $item = Cart::where('product_id', $cart->product_id)->delete();

        return Helper::returnResponse("success", "Deleted successfully");
    }

    /**
     * All carts removed
     */
    public function destroyAll()
    {
        Cart::truncate();
    }
}
