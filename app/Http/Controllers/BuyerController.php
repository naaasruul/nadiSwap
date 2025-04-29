<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        $deliveryAddresses = $user->deliveryAddresses; // Fetch all delivery addresses for the user

        // Logic to show the buyer's account details
        return view('buyer.account-profile', compact('user', 'ordersCount', 'reviewsCount', 'latestOrders','deliveryAddresses')); // Return the view for the buyer's account
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone_number' => 'required|string|max:15',
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|max:5120',
        ]);

        $user = auth()->user();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            try {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Store new avatar with username
                $extension = $request->file('avatar')->getClientOriginalExtension();
                $avatarPath = $request->file('avatar')->storeAs(
                    'avatars',
                    $user->username . '.' . $extension,
                    'public'
                );
                $user->avatar = $avatarPath;

            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to upload avatar: ' . $e->getMessage());
            }
        }


        $user->fill([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
