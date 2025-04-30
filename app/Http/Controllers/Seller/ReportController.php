<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all orders for the authenticated seller
        $orders = Order::where('seller_id', auth()->user()->id)->get();

        // Initialize variables
        $totalSales = $orders->sum('total');
        $totalOrders = $orders->count();
        $totalProductsSold = 0;
        $categories = [];

        // Prepare sales data for the chart
        $salesData = [];
        $salesDates = [];
        // Process each order to calculate category frequency
        foreach ($orders as $order) {
            $salesDates[] = $order->created_at->format('d M');
            $salesData[] = $order->total;

            // Decode the JSON data in the 'items' column
            $items = $order->items;

            foreach ($items as $item) {
                $category = $item['category'] ?? 'Unknown';
                $quantity = $item['quantity'] ?? 0;
                if($order->payment_status == 'paid') {
                    $totalProductsSold += $quantity;
                } 

                // Accumulate the total purchases for each category
                if (!isset($categories[$category])) {
                    $categories[$category] = 0;
                }
                $categories[$category] += $quantity;
            }
        }

        // Pass the data to the view
        return view('seller.reports', compact('totalSales','salesData', 'salesDates', 'totalOrders', 'totalProductsSold', 'categories'));
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
