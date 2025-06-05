<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allProducts = Product::where('seller_id', auth()->id())->get();
        
        $soldProducts = $allProducts->filter(function($product) {
            return $product->hasSales();
        });
        
        $unsoldProducts = $allProducts->filter(function($product) {
            return !$product->hasSales();
        });
        
        // Add total quantities to each sold product
        $soldProducts = $soldProducts->map(function($product) {
            $product->total_sold = $product->getTotalQuantitySold();
            return $product;
        });
        
        $categories = Category::all();
        
        return view('seller.products', compact('soldProducts', 'unsoldProducts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'images.*' => 'nullable|image|max:10240',
            ]);
    
            $imagePaths = [];
    
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    // Log image details
                    Log::info('Image Details:', [
                        'original_name' => $image->getClientOriginalName(),
                        'size' => $image->getSize(), // File size in bytes
                        'mime_type' => $image->getMimeType(),
                        'extension' => $image->getClientOriginalExtension(),
                    ]);
                    $imagePaths[] = $image->store('products', 'public');
                }
            }
            // Automatically assign the authenticated seller's ID
            $validated['seller_id'] = auth()->id();
            
            Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'category_id' => $validated['category_id'],
            'seller_id' => $validated['seller_id'],
            'images' => json_encode($imagePaths), // Save images as JSON
        ]);
    
            return redirect()->back()->with('success', 'Product created successfully.');
        }catch(Throwable $e){
            return redirect()->back()->with('error', 'Product cannot be upload because: '.$e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('seller.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!$product->canBeDeleted()) {
            return redirect()
                ->route('seller.products.index')
                ->with('error', 'Cannot delete product with existing orders.');
        }

        // Proceed with deletion if no orders exist
        if ($product->images) {
            $images = json_decode($product->images, true);
            foreach ($images as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $product->delete();
        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function show(Product $product)
    {
        $user = Auth::user();
        $canReview = false;

        if ($user && $user->hasRole('buyer')) {
            // Get all orders for this user
            $orders = \App\Models\Order::where('buyer_id', $user->id)->get();

            foreach ($orders as $order) {
                $items = json_decode($order->items, true);
                if (isset($items['cart_items']) && is_array($items['cart_items'])) {
                    // The keys of cart_items are the product IDs
                    if (array_key_exists($product->id, $items['cart_items'])) {
                        $canReview = true;
                        break;
                    }
                }
            }
        }

        // Calculate the average rating for the product
        $averageRating = $product->reviews()->avg('rating') ?? 0;

        return view('product.product-view', compact('product', 'averageRating', 'canReview'));
    }

    public function deleteMultiple(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->product_ids)
            ->where('seller_id', auth()->id())
            ->get();

        $nonDeletable = $products->filter(function($product) {
            return !$product->canBeDeleted();
        })->pluck('name');

        if ($nonDeletable->isNotEmpty()) {
            return response()->json([
                'error' => 'Some products cannot be deleted because they have orders: ' . 
                          $nonDeletable->implode(', ')
            ], 400);
        }

        foreach ($products as $product) {
            if ($product->images) {
                $images = json_decode($product->images, true);
                foreach ($images as $image) {
                    \Storage::disk('public')->delete($image);
                }
            }
            $product->delete();
        }

        return response()->json(['message' => 'Selected products deleted successfully.']);
    }
}
