<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;


class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('seller_id', auth()->id())->get();
        $totalProducts = Product::where('seller_id', auth()->id())->count();
        $totalBuyers = Order::where('seller_id', auth()->id())->distinct('buyer_id')->count();
        $newOrdersToday = Order::whereDate('created_at', now()->toDateString())->count();
        $totalSales = Order::sum('total');

        return view('seller.dashboard', compact(
            'totalProducts',
            'totalBuyers',
            'newOrdersToday',
            'totalSales',
            'orders'
        ));
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

    /**
     * Update the tracking status for an order.
     */
    public function updateTracking(Request $request, $orderId)
    {
        $request->validate([
            'tracking_status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $order = Order::where('id', $orderId)
            ->where('seller_id', auth()->id())
            ->firstOrFail();

        $order->tracking_status = $request->input('tracking_status');
        $order->save();

        return redirect()->back()->with('success', 'Tracking status updated.');
    }
}
