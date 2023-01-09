<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\Room;
use App\Notifications\NewBookingNotify;
use App\Notifications\OrderStatusNotify;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BookingService
{
    /**
     * product search and filter
     *
     * @param Request $request
     * @return string
     */
    public function storeBooking(Request $request)
    {
        $auth                    = auth()->user();
        $room                    = Room::find($request->room_id);
        $booking                 = new Booking();
        $booking->user_id        = $auth->id;
        $booking->customer_email = $auth->email;
        $booking->customer_number = $request->customer_number;
        $booking->room_id        = $room->id;
        $booking->date           = Carbon::now()->toDateString();
        $booking->check_in       = Carbon::parse($request->check_in)->toDateTimeString();
        $booking->check_out      = Carbon::parse($request->check_out)->toDateTimeString();
        $booking->address        = $request->address;
        $booking->note           = $request->note;
        $booking->sub_total      = $room->price;
        $booking->grand_total    = $room->price;
        $booking->save();
        return $booking;
    }

    /**
     * Order notify
     *
     * @param $order
     */
    private function customerOrderNotify($order)
    {
        $notify_details = [
            'greeting'   => "Hi {$order->user->name}",
            'body'       => "Your Order No: {$order->order_no}, Grand Total: Tk. {$order->grand_total}",
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Order Details',
            'actionURL'  => config('app.frontend_url') . '/order/' . $order->id,
            'order_id'   => $order->order_no
        ];
        Notification::send($order->user, new NewBookingNotify($notify_details));
    }

    /**
     * order status update notify
     *
     * @param Order $order
     */
    private function orderStatusNotify(Order $order)
    {
        $notify_details = [
            'greeting'   => "Hi {$order->user->name}",
            'body'       => "Your Order Status: {$order->status}",
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Order Details',
            'actionURL'  => config('app.frontend_url') . '/order/' . $order->id,
            'order_id'   => $order->order_no
        ];
        Notification::send($order->user, new OrderStatusNotify($notify_details));
    }

    /**
     * order status status update
     *
     * @param Order $order
     */
    public function orderStatusUpdate(Order $order, $status)
    {
        if ($status != 'Pending') {
            $history                        = $order->orderStatusHistory
                ?: new OrderStatusHistory();
            $history->{strtolower($status)} = Carbon::now()->toDateString();
            $order->orderStatusHistory()->save($history);

            //when order status delivered product quantity update
            if ($status == 'Delivered')
                $this->orderProductQtyUpdate($order);
        }
        //Customer Order status update notify
        $this->orderStatusNotify($order);
    }

    /**
     * when order status delivered product quantity update
     *
     * @param Order $order
     */
    private function orderProductQtyUpdate(Order $order)
    {
        foreach ($order->orderItems as $orderItem) {
            $orderItem->product()->decrement('quantity', $orderItem->quantity);
        }
    }

    /**
     * return orders with searching and filtering
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getOrdersWithSearchAndFilter(Request $request, $type = null)
    {
        $query = Order::query();
        if ($type == 'user') {
            $query->where('user_id', auth()->id());
        }
        if ($request->filled('search')) {
            $query->whereLike(['order_no', 'user.name', 'user.phone', 'user.email'], $request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        return $query->latest()->paginate($request->get('per_page', config('constant.mrhPagination')));
    }

    /**
     * return orders with searching and filtering
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getDeliveredOrdersWithSearchAndFilter(Request $request, $type = null)
    {
        $query = Delivery::query();
        if ($type == 'user') {
            $query->where('user_id', auth()->id());
        }
        if ($request->filled('search')) {
            $query->whereLike(['order_no', 'user.name', 'user.phone', 'user.email'], $request->search);
        }
        return $query->latest()->paginate($request->get('per_page', config('constant.mrhPagination')));
    }
}
