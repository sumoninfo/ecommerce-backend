<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $bookings = (new BookingService())->getBookings($request, 'user');
        return BookingResource::collection($bookings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookingRequest $request
     * @return JsonResponse
     */
    public function store(BookingRequest $request)
    {
        DB::beginTransaction();
        try {
            $booking = (new BookingService())->storeBooking($request);
            DB::commit();
            return Helper::returnResponse("success", "Order Created successfully", $booking);
        } catch (\Exception $e) {
            DB::rollback();
            return Helper::returnResponse("success", $e->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @param Request $request
     * @return BookingResource
     */
    public function show($id, Request $request)
    {
        $booking = Booking::where('user_id', auth()->id())->find($id);
        return new BookingResource($booking);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Booking $booking
     * @return JsonResponse
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return Helper::returnResponse("success", "Deleted successfully");
    }
}
