<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Delivery extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $fillable = [
        'user_id',
        'order_no',
        'date',
        'customer_email',
        'shipping_address',
        'sub_total',
        'discount',
        'shipping_cost',
        'grand_total',
        'order_note',
        'status',
    ];

    /**
     * get orders by status
     *
     * @param $query
     * @param $status
     * @return mixed
     */
    public function scopeStatus($query, $status)
    {
        return $query->where("status", $status);
    }

    /**
     * Get the User that the Order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,);
    }

    /**
     * relation with OrderItem
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(DeliveryItem::class, 'order_id', 'id');
    }

    /**
     * relation with order status history
     *
     * @return HasOne
     */
    public function orderStatusHistory(): HasOne
    {
        return $this->hasOne(DeliveryStatusHistory::class, 'order_id', 'id');
    }
}
