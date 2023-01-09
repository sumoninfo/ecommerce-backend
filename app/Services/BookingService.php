<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\Room;
use App\Notifications\NewBookingNotify;
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
     * Booking notify
     *
     * @param $booking
     */
    private function customerBookingNotify($booking)
    {
        $notify_details = [
            'greeting'   => "Hi {$booking->user->name}",
            'body'       => "Your Booking No: {$booking->booking_no}, Grand Total: Tk. {$booking->grand_total}",
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Booking Details',
            'actionURL'  => config('app.frontend_url') . '/order/' . $booking->id,
            'booking_no' => $booking->booking_no
        ];
        Notification::send($booking->user, new NewBookingNotify($notify_details));
    }

    /**
     * order status update notify
     *
     * @param Booking $booking
     */
    private function orderStatusNotify(Booking $booking)
    {
        $notify_details = [
            'greeting'   => "Hi {$booking->user->name}",
            'body'       => "Your Booking Status: {$booking->status}",
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Booking Details',
            'actionURL'  => config('app.frontend_url') . '/order/' . $booking->id,
            'booking_no' => $booking->booking_no
        ];
        Notification::send($booking->user, new BookingStatusNotify($notify_details));
    }

    /**
     * order status status update
     *
     * @param Booking $booking
     */
    public function orderStatusUpdate(Booking $booking, $status)
    {
        if ($status != 'Pending') {
            $history                        = $booking->orderStatusHistory
                ?: new BookingStatusHistory();
            $history->{strtolower($status)} = Carbon::now()->toDateString();
            $booking->orderStatusHistory()->save($history);

            //when order status delivered product quantity update
            if ($status == 'Delivered')
                $this->orderProductQtyUpdate($booking);
        }
        //Customer Booking status update notify
        $this->orderStatusNotify($booking);
    }

    /**
     * when order status delivered product quantity update
     *
     * @param Booking $booking
     */
    private function orderProductQtyUpdate(Booking $booking)
    {
        foreach ($booking->orderItems as $bookingItem) {
            $bookingItem->product()->decrement('quantity', $bookingItem->quantity);
        }
    }

}
