<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderCancellation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'cancelled_by_user_id',
        'cancellation_reason',
        'custom_cancellation_reason',
        'additional_comments',
        'cancelled_by_role',
        'cancelled_at',
    ];

    protected $casts = [
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the order that was cancelled.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user who cancelled the order.
     */
    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by_user_id');
    }

    /**
     * Get the final cancellation reason (custom or predefined).
     */
    public function getFinalReasonAttribute(): string
    {
        return $this->cancellation_reason === 'other' 
            ? $this->custom_cancellation_reason 
            : $this->cancellation_reason;
    }

    /**
     * Check if the cancellation has additional comments.
     */
    public function hasComments(): bool
    {
        return !empty($this->additional_comments);
    }

    /**
     * Get formatted cancellation date.
     */
    public function getFormattedCancelledAtAttribute(): string
    {
        return $this->cancelled_at->format('M d, Y \a\t g:i A');
    }

    /**
     * Scope to get cancellations by specific user role.
     */
    public function scopeByRole($query, string $role)
    {
        return $query->where('cancelled_by_role', $role);
    }

    /**
     * Scope to get recent cancellations.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('cancelled_at', '>=', now()->subDays($days));
    }
}
