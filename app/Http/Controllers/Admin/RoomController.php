<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoomRequest;
use App\Http\Resources\Admin\RoomResource;
use App\Models\Room;
use App\Repositories\Interfaces\RoomRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomController extends Controller
{
    private $repository;

    public function __construct(RoomRepositoryInterface $repository)
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
        return RoomResource::collection($amenities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoomRequest $request
     * @return JsonResponse
     */
    public function store(RoomRequest $request)
    {
        $data = $request->only(['name', 'price', 'size', 'maximum_occupancy', 'description', 'image', 'amenities']);
        $room = $this->repository->store($data);
        return Helper::returnResponse("success", "Created successfully", $room);
        try {
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return RoomResource
     */
    public function show(Room $room)
    {
        try {
            $room = $this->repository->find($room);
            return new RoomResource($room);
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Room $room
     * @return JsonResponse
     */
    public function update(Request $request, Room $room)
    {
        try {
            $data = $request->only(['name', 'price', 'size', 'maximum_occupancy', 'description', 'image', 'amenities']);
            $room = $this->repository->update($room, $data);
            return Helper::returnResponse("success", "Updated successfully", $room);
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Room $room
     * @return JsonResponse
     */
    public function destroy(Room $room)
    {
        try {
            $this->repository->destroy($room);
            return Helper::returnResponse("success", "Deleted successfully");
        } catch (\Exception $e) {
            return Helper::returnResponse("error", $e->getMessage(), [], $e->getCode());
        }
    }
}
