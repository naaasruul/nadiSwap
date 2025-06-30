<?php

namespace App\Http\Controllers\Rent;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    //
        public function findHousemate()
    {
        // Logic to show the find housemate page
        return view('buyer.find-housemate-form'); // Return the view for finding housemates
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'address' => 'required|string',
        'house_type' => 'required|string',
        'rent' => 'required|numeric',
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
