<?php

namespace App\Http\Controllers\Rent;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RentController extends Controller
{   
    //
    public function index(){
        // Logic to show the rent index page
        $products = Rent::all(); // Fetch all rent posts from the database
        return view('buyer.rent-view',compact('products')); // Return the view for rent index
    }
        public function findHousemate()
    {
        // Logic to show the find housemate page
        return view('buyer.find-housemate-form'); // Return the view for finding housemates
    }

    public function show($id)
    {
        // Logic to show the details of a specific rent post
        $product = Rent::findOrFail($id); // Fetch the rent post by ID
        return view('buyer.rent-details', compact('product')); // Return the view with the product details
    }

    public function store(Request $request)
{
    Log::info('RentController@store called', ['request' => $request->all()]);

    $validated = $request->validate([
        'address' => 'required|string',
        'house_type' => 'required|string',
        'rent' => 'required|numeric',
        'tenant_total' => 'required|numeric',
        'deposit' => 'nullable|numeric',
        'facilities' => 'nullable|string',
        'preferred_gender' => 'nullable|string',
        'other_preferences' => 'nullable|string',
        'house_images.*' => 'nullable|image',
        'other_payments' => 'nullable|array',
        'other_payments.*.name' => 'nullable|string',
        'other_payments.*.amount' => 'nullable|numeric',
    ]);

    // Save images
    $imagePaths = [];
    if ($request->hasFile('house_images')) {
        foreach ($request->file('house_images') as $image) {
            $imagePaths[] = $image->store('housemate_images', 'public');
        }
    }

    // Save to DB (example model: HousematePost)
    $post = Rent::create([
        'address' => $validated['address'],
        'house_type' => $validated['house_type'],
        'rent' => $validated['rent'],
        'tenant_total' => $validated['tenant_total'],
        'deposit' => $validated['deposit'],
        'facilities' => $validated['facilities'], // comma-separated
        'preferred_gender' => $validated['preferred_gender'],
        'other_preferences' => $validated['other_preferences'], // comma-separated
        'images' => json_encode($imagePaths),
        'other_payments' => json_encode($request->input('other_payments', [])),
        'user_id' => auth()->id(),
    ]);

    return response()->json(['success' => true, 'post_id' => $post->id]);
}
}
