<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'items',
        'total',
        'delivery_status',
        'payment_status',
        'payment_method',
        'file_receipt', // Add this line
        'order_status', // Add this line
    ];

    protected $casts = [
        'items' => 'array', // Cast items JSON to array
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * Get the order cancellation details.
     */
    public function cancellation(): HasOne
    {
        return $this->hasOne(OrderCancellation::class);
    }

    /**
     * Check if the order is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->order_status === 'cancelled';
    }

    /**
     * Get cancellation reason if order is cancelled.
     */
    public function getCancellationReasonAttribute(): ?string
    {
        return $this->cancellation?->final_reason;
    }
}
