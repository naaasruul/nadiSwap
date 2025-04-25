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

            // Increment weight for the first matching product's category
            if ($user && $products->count() > 0 && $products[0]->category) {
                $pref = \App\Models\UserCategoryPreference::firstOrCreate(
                    ['user_id' => $user->id, 'category' => $products[0]->category],
                    ['weight' => 0]
                );
                $pref->increment('weight');
                $preferredCategories[$products[0]->category] = $pref->weight;
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
}
