<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $fillable = [
        'user_id',
        'order_no',
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
        return $this->hasMany(OrderItem::class);
    }
}
