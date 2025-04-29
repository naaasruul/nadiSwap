<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ShippingFee;
use Illuminate\Http\Request;

class ShippingFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fees = ShippingFee::all();
        return view('seller.shipping-location-fee', compact('fees'));
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
        $request->validate([
            'location_name' => 'required|string',
            'price' => 'required',
        ]);

        ShippingFee::create([
            'location_name' => $request->location_name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Shipping fee created successfully.');
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
    public function update(Request $request, ShippingFee $shippingFee)
    {
        $request->validate([
            'location_name' => 'required|string',
            'price' => 'required',
        ]);

        $shippingFee->update([
            'location_name' => $request->location_name,
            'price' => $request->price,
        ]);

        return redirect()->back()->with('success', 'Shipping fee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingFee $shippingFee)
    {
        $shippingFee->delete();

        return redirect()->back()->with('success', 'Shipping fee deleted successfully.');
    }
}
