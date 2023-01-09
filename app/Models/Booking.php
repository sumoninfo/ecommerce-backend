<?php

namespace App\Models;

use App\Notifications\NewBookingNotify;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Notification;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * new booking notify to admin user
     *
     * @param $booking
     * @return void
     */
    public function adminBookingNotify($booking)
    {
        $admin   = Admin::first();
        $details = [
            'greeting'   => "Hi {$admin->name}, New Booking notify",
            'body'       => "New Booking: Customer name: {$booking->user->name}, Booking No: {$booking->booking_no}, Grand Total: Tk."
                            . number_format($booking->grand_total, 2),
            'thanks'     => 'Thank you very much for doing business with us.',
            'actionText' => 'Booking Details',
            'actionURL'  => config('app.frontend_url') . '/admin/booking/' . $booking->id,
            'booking_no' => $booking->booking_no
        ];
        Notification::send($admin, new NewBookingNotify($details));
    }

    /**
     * Get the User that owns the Booking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Room that owns the Booking
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
