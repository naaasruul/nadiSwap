<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ListOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::all();
        return view('admin.orders',compact('orders'));    
    }

    public function paymentStatusIndex()
    {
        //
        $orders = Order::all();
        return view('admin.payment-orders',compact('orders'));    
    }

    public function deliveryStatusIndex()
    {
        //
        $orders = Order::all();
        return view('admin.delivery-orders',compact('orders'));    
    }

    public function orderStatusIndex()
    {
        //
        $orders = Order::all();
        return view('admin.status-orders',compact('orders'));    
    }

    public function showDelivery(Order $order)
    {
        Log::info('Showing delivery for order: ' . $order->id);

        $cancelledOrder = $order->cancellation()->latest()->first();
        return view('admin.delivery-order-info',compact('order', 'cancelledOrder'));    
    }

    public function showPayment(Order $order)
    {
        Log::info('Showing delivery for order: ' . $order->id);

        $cancelledOrder = $order->cancellation()->latest()->first();
        return view('admin.payment-order-info',compact('order', 'cancelledOrder'));    
    }

    public function showOrderStatus(Order $order)
    {
        Log::info('Showing delivery for order: ' . $order->id);

        $cancelledOrder = $order->cancellation()->latest()->first();
        return view('admin.status-order-info',compact('order', 'cancelledOrder'));
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
}
