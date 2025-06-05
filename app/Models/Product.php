<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'seller_id',
        'price',
        'stock',
        'category_id',
        'images',
        'rating'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'items', 'id');
    }

    public function hasOrders(): bool
    {
        return Order::where("items->cart_items->{$this->id}", '!=', null)->exists();
    }

    public function canBeDeleted(): bool
    {
        return !$this->hasOrders();
    }

    public function hasSales(): bool
    {
        $orders = Order::where('order_status', '!=', 'cancelled')->get();
        Log::info('Checking orders: ' . $orders);

        foreach ($orders as $order) {
            // Single decode - items is single-encoded JSON
            $items = json_decode($order->items, true);
            Log::info('Decoded items for order ' . $order->id . ': ', $items);
            Log::info('Looking for product ID: ' . $this->id);

            if (is_array($items) && isset($items['cart_items'][$this->id])) {
                Log::info('Found product ' . $this->id . ' in order ' . $order->id);
                return true;
            }
        }

        Log::info('Product ' . $this->id . ' not found in any orders');
        return false;
    }

    public function getTotalQuantitySold(): int
    {
        $orders = Order::where('order_status', '!=', 'cancelled')->get();

        $totalQuantity = 0;
        foreach ($orders as $order) {
            // Single decode - items is single-encoded JSON
            $items = json_decode($order->items, true);
            if (is_array($items) && isset($items['cart_items'][$this->id]['quantity'])) {
                $totalQuantity += (int) $items['cart_items'][$this->id]['quantity'];
            }
        }

        return $totalQuantity;
    }
}
