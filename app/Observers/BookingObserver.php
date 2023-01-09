<?php

namespace App\Observers;

use App\Helpers\Helper;
use App\Models\Booking;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function created(Booking $booking)
    {
        $booking->booking_no = Helper::generateBookingNo($booking->id);
        $booking->save();
        $booking->adminBookingNotify($booking);
    }

    /**
     * Handle the Booking "updated" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function updated(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function restored(Booking $booking)
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     *
     * @param \App\Models\Booking $booking
     * @return void
     */
    public function forceDeleted(Booking $booking)
    {
        //
    }
}
