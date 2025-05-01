<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        $orders = Order::all();
        $products = Product::all();
        $reviews = Review::all();

        $sellers = User::role('seller')->get(); // Fetch all sellers
        $buyers = User::role('buyer')->get(); // Fetch all buyers
        $admins = User::role('admin')->get(); // Fetch all admins

        $buyersCount = $buyers->count();
        $sellersCount = $sellers->count();

        // Group transactions by day and count them
        $transactions = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Prepare data for the chart
        $transactionDates = $transactions->pluck('date')->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('d F'); // Format date as '01 February'
        });
        $transactionCounts = $transactions->pluck('count');

        // Calculate order statuses
        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $cancelledOrders = Order::where('payment_status', 'cancelled')->count();


        return view('admin.dashboard',compact(
            'users',
            'orders',
            'products',
            'reviews',
            'sellers',
            'buyers',
            'admins',
            'buyersCount',
            'sellersCount',
            'transactionDates',
            'transactionCounts',
            'pendingOrders',
            'paidOrders',
            'cancelledOrders'
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

    public function showManageSeller()
    {
        // Show the manage seller view
        // You can pass any data to the view if needed
        $sellers = User::role('seller')->get(); // Fetch all sellers
        return view('admin.manage-seller',compact('sellers'));
    }

    public function showManageBuyer()
    {
        // Show the manage buyer view
        // You can pass any data to the view if needed
        $buyers = User::role('buyer')->get(); // Fetch all buyers
        return view('admin.manage-buyer',compact('buyers'));
    }
}
