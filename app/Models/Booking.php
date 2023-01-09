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
