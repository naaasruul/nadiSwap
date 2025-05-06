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
use Throwable;

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
        Log::debug('Cart items:', ['data' => $cartItems]); // <-- debugging log
        Log::debug('User addresses:', ['data' => $addresses->toArray()]); // <-- debugging log

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
                'seller_id' => $product->seller_id, // <-- added seller_id
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
        try {
            $cart = Session::get('cart', []);
            Log::debug('Checkout initiated. Cart:', $cart);

            if (empty($cart)) {
                Log::debug('Cart is empty during checkout.');
                return redirect()->back()->with('error', 'Your cart is empty!');
            }

            // Validate the file receipt if payment method is not COD
            $validatedData = $request->validate([
                'file_receipt' => $request->input('payment_method') !== 'cod' ? 'required|mimes:jpg,jpeg,png,pdf|max:10240' : 'nullable',
            ]);

            $fileReceiptPath = null;

            // Handle file upload
            if ($request->hasFile('file_receipt')) {
                $fileReceiptPath = $request->file('file_receipt')->store('receipts', 'public');
                Log::debug('File receipt uploaded:', ['path' => $fileReceiptPath]);
            }

            // Update cart quantities from JSON input (hidden inputs)
            if ($request->has('cart')) {
                $updated = $request->input('cart');
                foreach ($updated as $id => $data) {
                    if (isset($cart[$id])) {
                        $cart[$id]['quantity'] = (int)$data['quantity'];
                    }
                }
                Session::put('cart', $cart);
                Log::debug('Updated cart with new quantities:', $cart);
            }

            // Retrieve shipping selections: shipping[product_id] => shipping option id
            $shippingSelected = $request->input('shipping', []);

            // Group items by seller
            $groupedItems = [];
            foreach ($cart as $id => $item) {
                $product = Product::findOrFail($id);
                $groupedItems[$product->seller_id][$id] = $item;
            }
            Log::debug('Grouped cart items by seller:', $groupedItems);

            // Create orders for each seller using recalculated totals including shipping fees.
            foreach ($groupedItems as $sellerId => $items) {
                $productSubtotal = 0;
                $shippingTotal = 0;

                foreach ($items as $id => &$item) {
                    $productSubtotal += $item['price'] * $item['quantity'];
                    if (isset($shippingSelected[$id])) {
                        $item['shipping_id'] = $shippingSelected[$id];
                        $shippingOption = Shipping::find($shippingSelected[$id]);
                        if ($shippingOption) {
                            $shippingTotal += $shippingOption->shipping_fee * $item['quantity'];
                        }
                    } else {
                        $item['shipping_id'] = null;
                    }

                    // Reduce stock for the product
                    $product = Product::findOrFail($id);
                    if ($product->stock >= $item['quantity']) {
                        $product->stock -= $item['quantity'];
                        $product->save();
                        Log::debug("Stock reduced for product ID {$id}. Remaining stock: {$product->stock}");
                    } else {
                        Log::debug("Insufficient stock for product ID {$id}. Requested: {$item['quantity']}, Available: {$product->stock}");
                        return redirect()->back()->with('error', "Insufficient stock for product: {$product->name}");
                    }
                }
                unset($item); // Break reference

                $grandTotal = $productSubtotal + $shippingTotal;

                $orderItems = [
                    'delivery_address_id' => $request->input('delivery_address'),
                    'cart_items' => $items,
                    'shipping_total' => $shippingTotal,
                ];

                // Encode $orderItems as JSON
                $orderItemsJson = json_encode($orderItems);

                Order::create([
                    'buyer_id' => Auth::id(),
                    'seller_id' => $sellerId,
                    'items' => $orderItemsJson,
                    'total' => $grandTotal,
                    'payment_method' => $request->input('payment_method', 'qr'),
                    'payment_status' => $request->input('payment_method') === 'cod' ? 'pending' : 'paid', // Dynamically set status
                    'file_receipt' => $fileReceiptPath, // Save the file receipt path
                ]);
                Log::debug("Order created for seller_id: {$sellerId} with grand total: {$grandTotal}", $items);
            }

            // Clear the cart
            Session::forget('cart');
            Log::debug('Cart cleared after checkout.');

            return redirect()->route('buyer.dashboard')->with('success', 'Order placed successfully!');
        } catch (Throwable $e) {
            Log::debug('Something went wrong:: ' . $e);
            return redirect()->back()->with('error', 'Error occurred: ' . $e->getMessage());
        }
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
