<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Delivery;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookingController extends Controller
{
    /**
     * get bookings
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function getBookings(Request $request): AnonymousResourceCollection
    {
        $bookings = (new BookingService())->getBookings($request);
        return BookingResource::collection($bookings);
    }

    /**
     * Booking Status update
     *
     * @param Booking $booking
     * @param $status
     * @return JsonResponse
     */
    public function bookingStatusUpdate(Booking $booking, $status)
    {
        $booking->status = $status;
        $booking->save();
        //Store and updated booking status history with date
        (new BookingService())->bookingStatusNotify($booking);
        return Helper::returnResponse("success", "Booking Status update successfully", $booking);
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
        $booking = Booking::find($id);
        return new BookingResource($booking);
    }
}
