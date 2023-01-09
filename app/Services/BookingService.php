<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Room;
use App\Notifications\BookingStatusNotify;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingService
{

    /**
     * return bookings data with searching and filtering
     *
     * @param Request $request
     * @param null $type
     * @return LengthAwarePaginator
     */
    public function getBookings(Request $request, $type = null)
    {
        $query = Booking::query();
        if ($type == 'user') {
            $query->where('user_id', auth()->id());
        }
        if ($request->filled('search')) {
            $query->whereLike(['booking_no', 'customer_number', 'user.name', 'user.phone', 'user.email'], $request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return $query->latest()->paginate($request->get('per_page', config('constant.pagination')));
    }

    /**
     * Store booking data
     *
     * @param Request $request
     * @return string
     */
    public function storeBooking(Request $request)
    {
        $auth                     = auth()->user();
        $room                     = Room::find($request->room_id);
        $booking                  = new Booking();
        $booking->user_id         = $auth->id;
        $booking->customer_email  = $auth->email;
        $booking->customer_number = $request->customer_number;
        $booking->room_id         = $room->id;
        $booking->date            = Carbon::now()->toDateString();
        $booking->check_in        = Carbon::parse($request->check_in)->toDateTimeString();
        $booking->check_out       = Carbon::parse($request->check_out)->toDateTimeString();
        $booking->address         = $request->address;
        $booking->note            = $request->note;
        $booking->sub_total       = $room->price;
        $booking->grand_total     = $room->price;
        $booking->save();
        return $booking;
    }

    /**
     * booking status update notify
     *
     * @param Booking $booking
     */
    public function bookingStatusNotify(Booking $booking)
    {
        $notify_details = [
            'greeting'   => "Hi {$booking->user->name}",
            'body'       => "Your Booking : {$booking->status},  Booking No: {$booking->booking_no}",
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Booking Details',
            'actionURL'  => config('app.frontend_url') . '/booking/' . $booking->id,
            'booking_no' => $booking->booking_no
        ];
        Notification::send($booking->user, new BookingStatusNotify($notify_details));
    }

}
