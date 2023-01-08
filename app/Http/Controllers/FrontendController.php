<?php

namespace App\Http\Controllers;

use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\RoomResource;
use App\Models\Product;
use App\Models\Room;
use App\Repositories\RoomRepository;
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

    public function getRooms(Request $request, RoomRepository $repository)
    {
        return RoomResource::collection($repository->all($request));
    }

    public function getRoom(Room $room, RoomRepository $repository)
    {
        return new RoomResource($repository->find($room));
    }

    public function checkProductStock(Product $product)
    {
        return $product->quantity;
    }

}
