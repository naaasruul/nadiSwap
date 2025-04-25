<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserCategoryPreference;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $user = auth()->user();
        $preferredCategories = [];

        // Get user's category preferences with weights
        if ($user) {
            $preferredCategories = $user->categoryPreferences()
                ->orderByDesc('weight')
                ->pluck('weight', 'category')
                ->toArray();
        }

        if ($search) {
            $products = Product::query()
                ->when($search, function($query, $search) {
                    return $query->where('name', 'like', '%' . $search . '%');
                })
                ->get();

            // Adjust weights based on search frequency
            if ($user && $products->count() > 0) {
                // Count categories in search results
                $categoryCounts = [];
                foreach ($products as $product) {
                    if ($product->category) {
                        $categoryCounts[$product->category] = ($categoryCounts[$product->category] ?? 0) + 1;
                    }
                }
                // Increase weight for categories found, decrease for others
                foreach ($categoryCounts as $category => $count) {
                    $pref = \App\Models\UserCategoryPreference::firstOrCreate(
                        ['user_id' => $user->id, 'category' => $category],
                        ['weight' => 0]
                    );
                    $pref->increment('weight', $count); // Increase by frequency in search results
                    $preferredCategories[$category] = $pref->weight;
                }
                // Decay weights for categories not found in this search (by 1 per search, not by count)
                //TODO- decay weights slower
                $allCategories = array_keys($preferredCategories);
                foreach ($allCategories as $category) {
                    if (!isset($categoryCounts[$category])) {
                        $pref = \App\Models\UserCategoryPreference::where([
                            'user_id' => $user->id,
                            'category' => $category
                        ])->first();
                        if ($pref && $pref->weight > 0) {
                            $pref->decrement('weight', 1); // Only decrement by 1 per search
                            $preferredCategories[$category] = $pref->weight;
                        }
                    }
                }
            }
        } else {
            $products = Product::all();
        }

        // Sort products by user's category weights
        if ($user && count($preferredCategories)) {
            $products = $products->sortByDesc(function($product) use ($preferredCategories) {
                return $preferredCategories[$product->category] ?? 0;
            })->values();
        }

        // Show the top preferred category (optional)
        $topCategory = count($preferredCategories) ? array_key_first($preferredCategories) : null;

        return view('buyer.dashboard', [
            'products' => $products,
            'recommendedCategory' => $topCategory,
        ]);
    }

    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        $user = auth()->user();
        if ($user && $product->category) {
            $pref = \App\Models\UserCategoryPreference::firstOrCreate(
                ['user_id' => $user->id, 'category' => $product->category],
                ['weight' => 0]
            );
            $pref->increment('weight');
        }
        // Logic to show the product details
        return view('buyer.product-details', compact('product')); // Return the view for the product details
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

    public function resetRecommendations(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->categoryPreferences()->delete();
        }
        return redirect()->route('buyer.dashboard')->with('status', 'Recommendations reset.');
    }
}
