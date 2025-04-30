<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Fetch orders from the database or any other source
        $orders = Order::where('seller_id', auth()->user()->id)->get();

        return view('seller.orders',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePaymentStatus(Request $request, Order $order)
{
    try {
        // Validate the request
        $request->validate([
            'payment_status' => 'required|string|in:pending,paid,failed',
        ]);

        // Update the payment status
        $order->update(['payment_status' => $request->payment_status]);

        session()->flash('success', 'Payment status updated successfully.');

        // Return success response
        return response()->json([
            'message' => 'Payment status updated successfully.',
            'payment_status' => $order->payment_status,
        ], 200);
    } catch (\Exception $e) {
        // Handle any unexpected errors
        return response()->json([
            'message' => 'Failed to update payment status.',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function updateDeliveryStatus(Request $request, Order $order)
{
    
    try {
        // Validate the request
        $request->validate([
            'delivery_status' => 'required|string|in:ood,shipped,delivered,cancelled',
        ]);

        // Update the delivery status
        $order->update(['delivery_status' => $request->delivery_status]);

        // Return success response
        return response()->json([
            'message' => 'Delivery status updated successfully.',
            'delivery_status' => $order->delivery_status,
        ], 200);
    } catch (\Exception $e) {
        // Handle any unexpected errors
        return response()->json([
            'message' => 'Failed to update delivery status.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}
