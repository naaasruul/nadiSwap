<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log as FacadesLog;

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
            $items = json_decode($order->items, true); // Ensure items is decoded as an array

            // $items = $order->items; // Ensure items is decoded as an array


            if (is_array($items) && isset($items['cart_items'])) { // Check if $items is an array and contains 'cart_items'
                foreach ($items['cart_items'] as $item) { // Iterate over 'cart_items'
                    FacadesLog::warning('Item:', ['data' => $item]); // Debugging log for individual item
                    
                    $category = $item['category']['name'] ?? 'Unknown'; // Access category name
                    $quantity = $item['quantity'] ?? 0;
            
                    if ($order->payment_status == 'paid') {
                        $totalProductsSold += $quantity;
                    }
            
                    // Accumulate the total purchases for each category
                    if (!isset($categories[$category])) {
                        $categories[$category] = 0;
                    }
                    $categories[$category] += $quantity;
            
                    // Debugging log for categories
                    FacadesLog::warning('Category:', ['data' => $categories]);
                }
            } else {
                // Handle the case where items is not an array or does not contain 'cart_items'
                \Log::warning('Items is not an array or does not contain cart_items for order ID: ' . $order->id);
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
