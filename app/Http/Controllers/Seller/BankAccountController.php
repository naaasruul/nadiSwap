<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('seller.bank-account');
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
        $validated = $request->validate([
            'bank_acc_name' => 'required|string|max:255',
            'bank_acc_number' => 'required|string|max:255',
            'bank_type' => 'required|string|max:255',
        ]);
    
        $seller = auth()->user(); // Assuming the seller is authenticated

        // Create or update the bank account
        BankAccount::updateOrCreate(
            ['seller_id' => $seller->id], // Condition to find the record
            $validated // Data to update or create
        );
    
        return redirect()->back()->with('success', 'Bank account details saved successfully.');
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
