<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping; // <-- added for shipping lookup
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // <-- added for debugging

class CartController extends Controller
{
    //

    public function index()
    {
        $cart = Session::get('cart', []);
        
        // Prepare cart items with shipping options and default shipping fee
        $cartItems = [];
        foreach ($cart as $id => $item) {
            $shippings = Shipping::where('seller_id', $item['seller_id'])->get();
            $item['shippings'] = $shippings;
            $item['selected_shipping_fee'] = $shippings->isNotEmpty() ? $shippings->first()->shipping_fee : 0;
            $cartItems[$id] = $item;
        }
        
        // Retrieve the authenticated user's delivery addresses (fixing empty result)
        $addresses = Auth::user()->deliveryAddresses ?? collect([]);
        \Log::debug('Cart items:', ['data' => $cartItems]); // <-- debugging log
        \Log::debug('User addresses:', ['data' => $addresses->toArray()]); // <-- debugging log
        
        return view('cart.index', compact('cartItems', 'addresses'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $productThumbnail = json_decode($product->images)[0];
        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category,
                'quantity' => $request->quantity,
                'image'    => $productThumbnail,
                'seller_id'=> $product->seller_id, // <-- added seller_id
            ];
        }

        Session::put('cart', $cart);
        Log::debug('Cart updated after add:', $cart); // <-- debugging log

        if ($request->ajax()) {
            return view('partials.cart-items', compact('cart'));
        } else {
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
    }

    public function checkout(Request $request)
    {
        $cart = Session::get('cart', []);
        Log::debug('Checkout initiated. Cart:', $cart); // <-- debugging log

        if (empty($cart)) {
            Log::debug('Cart is empty during checkout.');
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        // Group items by seller
        $groupedItems = [];
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            $groupedItems[$product->seller_id][] = $item;
        }
        Log::debug('Grouped cart items by seller:', $groupedItems); // <-- debugging log

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
            Log::debug("Order created for seller_id: {$sellerId} with total: {$total}", $items);
        }

        // Clear the cart
        Session::forget('cart');
        Log::debug('Cart cleared after checkout.');

        return redirect()->back()->with('success', 'Order placed successfully!');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
            Log::debug("Item {$id} removed from cart.", $cart); // <-- debugging log
        }
        return redirect()->back()->with('success', 'Item removed from cart.');
    }
}
