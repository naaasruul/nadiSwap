<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    //

    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Session::get('cart', []);

        // Check if the product is already in the cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category,
                'quantity' => $request->quantity,
                'image' => $product->image,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        // Group items by seller
        $groupedItems = [];
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            $groupedItems[$product->seller_id][] = $item;
        }

        // Create orders for each seller
        foreach ($groupedItems as $sellerId => $items) {
            $total = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $items));

            Order::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $sellerId,
                'items' => $items,
                'total' => $total,
                'payment_method' => 'qr',
                'status' => 'Pending',
            ]);
        }

        // Clear the cart
        Session::forget('cart');

        return redirect()->back()->with('success', 'Order placed successfully!');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
