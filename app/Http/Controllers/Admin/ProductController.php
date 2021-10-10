<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        $query = $query->latest()->paginate($request->get('per_page', config('constant.pagination')));
        return ProductResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        if (!empty($request->image)) {
            $product->image = Helper::fileUpload($request->image);
        }
        $request->offsetUnset('image');
        $product->fill($request->all());
        $product->save();
        return Helper::returnResponse("success", "ProductService Created successfully", $product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        if ($request->filled('image')) {
            if (Storage::disk('public')->exists('products/' . $product->image)) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            $product->image = Helper::fileUpload($request->image);
        }
        $request->offsetUnset('image');
        $product->fill($request->all());
        $product->update();
        return Helper::returnResponse("success", "Updated successfully", $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        if (Storage::disk('public')->exists('products/' . $product->image)) {
            Storage::disk('public')->delete('products/' . $product->image);
        }
        $product->delete();
        return Helper::returnResponse("success", "Deleted successfully");
    }
}
