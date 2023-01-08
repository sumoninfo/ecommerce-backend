<?php

namespace App\Repositories;

use App\Repositories\Interfaces\AmenityRepositoryInterface;
use App\Models\Amenity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class AmenityRepository implements AmenityRepositoryInterface
{
    public function all(Request $request): LengthAwarePaginator
    {
        $query = Amenity::query();
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }
        return $query->latest()->paginate($request->get('per_page', config('constant.pagination')));
    }

    public function store($data)
    {
        return Amenity::create($data);
    }

    public function find($model)
    {
        return $model;
    }

    public function update($model, $data)
    {
        return $model->update($data);
    }

    public function destroy($model)
    {
        $model->delete();
    }
}
