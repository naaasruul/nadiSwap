<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::all(); // Fetch all products from the database

        return view('buyer.dashboard',compact('products')); // Pass the products to the view
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

    public function showAccount()
    {
        $user = auth()->user();
        $ordersCount = $user->orders()->count() ?? 0;
        $reviewsCount = $user->reviews()->count() ?? 0;
        $latestOrders = $user->orders()->latest()->take(5)->get();

        // Logic to show the buyer's account details
        return view('buyer.account-profile', compact('user', 'ordersCount', 'reviewsCount', 'latestOrders')); // Return the view for the buyer's account
    }
}
