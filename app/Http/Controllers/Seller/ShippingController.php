<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippings = Shipping::all();
        return view('seller.shipping', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.shippings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'place' => 'required|string|max:255',
            'shipping_fee' => 'required|numeric|min:0',
        ]);

        
        if($validate){
            Shipping::create(
                [
                    'place' => $request->place,
                    'shipping_fee' => $request->shipping_fee,
                    'seller_id' => Auth()->user()->id,
                ]
            );
        }

        return redirect()->route('seller.shippings.index')->with('success', 'Shipping created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipping $shipping)
    {
        return view('seller.shippings.show', compact('shipping'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipping $shipping)
    {
        return view('seller.shippings.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipping $shipping)
    {
        $request->validate([
            'place' => 'required|string|max:255',
            'shipping_fee' => 'required|numeric|min:0',
        ]);

        $shipping->update($request->all());

        return redirect()->route('seller.shippings.index')->with('success', 'Shipping updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipping $shipping)
    {
        $shipping->delete();

        return redirect()->route('seller.shippings.index')->with('success', 'Shipping deleted successfully.');
    }
}
