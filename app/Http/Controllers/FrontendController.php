<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FrontendController extends Controller
{
    /**
     * return products with searching and filtering
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getProducts(Request $request): AnonymousResourceCollection
    {
        $products = (new ProductService())->productSearchWithFilter($request);
        return ProductResource::collection($products);
    }

    public function checkProductStock(Product $product)
    {
        return $product->quantity;
    }

}
