<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ProductService
{
    /**
     * product search and filter
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function productSearchWithFilter(Request $request): LengthAwarePaginator
    {
        $query = Product::query();
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        if ($request->filled('sort_by')) {
            $query->orderBy('price', $request->sort_by);
        }
        return $query->paginate($request->get('per_page', config('constant.pagination')));
    }
}
