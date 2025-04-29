<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // Get the authenticated seller's ID
        $sellerId = Auth::id();

        // Retrieve reviews for products that belong to the seller
        $reviews = Review::whereHas('product', function ($query) use ($sellerId) {
            $query->where('seller_id', $sellerId);
        })->get();
        return view('seller.reviews', compact('reviews'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $validated['product_id'] = $product->id;
        $validated['user_id'] = Auth::id();

        Review::create($validated);

        return redirect()->back()->with('success', 'Review added successfully.');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this review.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    public function respond(Request $request, Review $review)
{
    $request->validate([
        'response' => 'required|string|max:1000',
    ]);

    $review->update([
        'response' => $request->response,
    ]);

    return redirect()->route('seller.reviews.index')->with('success', 'Response submitted successfully.');
}
}
