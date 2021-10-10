<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryItem extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'sub_total'
    ];

    /**
     * Get the Order that the OrderItem.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    /**
     * Get the product that the OrderItem.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
