<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryAddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'address_line_1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        auth()->user()->deliveryAddresses()->create($request->all());

        return redirect()->back()->with('success', 'Delivery address added successfully.');
    }
}
