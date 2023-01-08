<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AmenityRequest;
use App\Http\Resources\Admin\AmenityResource;
use App\Models\Amenity;
use App\Repositories\Interfaces\AmenityRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AmenityController extends Controller
{
    private $repository;

    public function __construct(AmenityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $amenities = $this->repository->all($request);
        return AmenityResource::collection($amenities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AmenityRequest $request
     * @return JsonResponse
     */
    public function store(AmenityRequest $request)
    {
        try {
            $data    = $request->only(['name']);
            $amenity = $this->repository->store($data);
            return Helper::returnResponse("success", "Created successfully", $amenity);
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Amenity $amenity
     * @return AmenityResource
     */
    public function show(Amenity $amenity)
    {
        try {
            $amenity = $this->repository->find($amenity);
            return new AmenityResource($amenity);
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Amenity $amenity
     * @return JsonResponse
     */
    public function update(Request $request, Amenity $amenity)
    {
        try {
            $data    = $request->only(['name']);
            $amenity = $this->repository->update($amenity, $data);
            return Helper::returnResponse("success", "Updated successfully", $amenity);
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Amenity $amenity
     * @return JsonResponse
     */
    public function destroy(Amenity $amenity)
    {
        try {
            $this->repository->destroy($amenity);
            return Helper::returnResponse("success", "Deleted successfully");
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }
}
