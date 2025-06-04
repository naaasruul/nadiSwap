<x-layouts.app :title="__('Cancel Order')">
    <div class="min-h-screen bg-gray-50 p-5">
        <!-- Header -->
        @php
            $statusConfig = match ($order->order_status) {
                'completed' => [
                    'text' => 'Completed', 
                    'bg' => 'bg-green-500', 
                    'icon' => '✅',
                    'headerGradient' => 'bg-gradient-to-r from-green-600 to-emerald-700',
                    'borderColor' => 'border-green-300',
                    'textColor' => 'text-green-100'
                ],
                'cancelled' => [
                    'text' => 'Cancelled', 
                    'bg' => 'bg-red-500', 
                    'icon' => '❌',
                    'headerGradient' => 'bg-gradient-to-r from-red-600 to-red-700',
                    'borderColor' => 'border-red-300',
                    'textColor' => 'text-red-100'
                ],
                default => [
                    'text' => 'Pending', 
                    'bg' => 'bg-yellow-500', 
                    'icon' => '⏳',
                    'headerGradient' => 'bg-gradient-to-r from-yellow-500 to-orange-600',
                    'borderColor' => 'border-yellow-300',
                    'textColor' => 'text-yellow-100'
                ],
            };
        @endphp
        <div class="{{ $statusConfig['headerGradient'] }} text-white rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h1>
                        <p class="{{ $statusConfig['textColor'] }}">Received on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center space-x-3">
                            <span class="text-2xl">{{ $statusConfig['icon'] }}</span>
                            <div>
                                <div class="flex justify-end">
                                    <div class="px-4 py-2 {{ $statusConfig['bg'] }} rounded-full text-white font-semibold w-max">
                                        {{ $statusConfig['text'] }}
                                    </div>
                                </div>
                                <p class="{{ $statusConfig['textColor'] }} text-sm mt-1">Order Status</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-8">
            @if($order->order_status == 'pending')
                <!-- Order Cancellation Main Section -->
                <div class="w-full">
                    <!-- Seller Cancellation Notice -->
                    <div class="bg-orange-50 border-l-4 border-orange-500 p-6 mb-8 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="text-orange-500 text-2xl">⚠️</span>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-bold text-orange-800 mb-2">Cancel Customer Order</h2>
                                <p class="text-orange-700">
                                    You're about to cancel order #{{ $order->id }} from {{ optional($order->buyer)->name ?? 'Customer' }}. 
                                    The customer will be notified automatically. Please provide a clear reason for the cancellation.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid xl:grid-cols-2 gap-8">
                        <!-- Left Column: Order & Customer Details -->
                        <div class="space-y-6">
                            <!-- Customer Information -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-800">
                                    <span class="w-2 h-2 bg-purple-600 rounded-full mr-3"></span>
                                    Customer Information
                                </h3>
                                
                                <div class="flex items-center mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">
                                        {{ substr(optional($order->buyer)->name ?? 'C', 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 text-lg">{{ optional($order->buyer)->name ?? 'N/A' }}</h4>
                                        <p class="text-gray-600">{{ optional($order->buyer)->phone_number ?? 'N/A' }}</p>
                                        <p class="text-gray-600 text-sm">{{ optional($order->buyer)->email ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                @php
                                    $items = json_decode($order->items, true);
                                    $address_id = $items['delivery_address_id'] ?? null;
                                    $address = \App\Models\DeliveryAddress::find($address_id);
                                @endphp
                                
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">📍 Delivery Address</p>
                                    <p class="text-gray-700 text-sm">
                                        {{ $address ? implode(', ', array_filter([
                                            $address->address_line_1,
                                            $address->address_line_2,
                                            $address->city,
                                            $address->state,
                                            $address->postal_code
                                        ])) : 'No address provided' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-800">
                                    <span class="w-2 h-2 bg-green-600 rounded-full mr-3"></span>
                                    Order Items
                                </h3>
                                
                                @php
                                    $cartItems = $items['cart_items'] ?? [];
                                    $shippingTotal = $items['shipping_total'] ?? 0;
                                @endphp
                                
                                <div class="space-y-4 mb-6">
                                    @foreach($cartItems as $productId => $item)
                                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                                            <div class="w-20 h-20 bg-white rounded-lg overflow-hidden shadow-sm mr-4">
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 mb-1">{{ $item['name'] }}</h4>
                                                <p class="text-gray-600 text-sm mb-2">SKU: {{ $productId }}</p>
                                                <div class="flex items-center justify-between">
                                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                        Qty: {{ $item['quantity'] }}
                                                    </span>
                                                    <span class="font-semibold text-gray-900 text-lg">RM{{ number_format($item['price'], 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Order Total -->
                                <div class="border-t pt-4">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Items Subtotal</span>
                                        <span>RM{{ number_format($order->total - $shippingTotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-3">
                                        <span class="text-gray-600">Shipping Fee</span>
                                        <span>RM{{ number_format($shippingTotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold text-orange-600 border-t pt-3">
                                        <span>Total Order Value</span>
                                        <span>RM{{ number_format($order->total, 2) }}</span>
                                    </div>
                                    <p class="text-gray-500 text-sm mt-2">
                                        Payment Method: {{ ucfirst($order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Banking') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Cancellation Form -->
                        <div class="bg-white rounded-xl shadow-sm border-l-4 border-l-orange-500 p-6">
                            <h3 class="text-xl font-bold text-orange-700 mb-6 flex items-center">
                                <span class="mr-3">🚫</span>
                                Order Cancellation
                            </h3>

                            <form action="{{ route('seller.orders.cancel', $order->id) }}" method="POST" id="seller-cancellation-form">
                                @csrf
                                @method('PATCH')
                                
                                <!-- Cancellation Reason -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-800 mb-4">
                                        Reason for cancelling this order <span class="text-red-500">*</span>
                                    </label>
                                    
                                    <div class="space-y-3">
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Out of stock" class="mt-1 mr-3 text-orange-600 focus:ring-orange-500" {{ old('cancellation_reason') == 'Out of stock' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800">Out of stock</span>
                                                <p class="text-gray-600 text-sm mt-1">Product is no longer available</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Unable to fulfill delivery" class="mt-1 mr-3 text-orange-600 focus:ring-orange-500" {{ old('cancellation_reason') == 'Unable to fulfill delivery' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800">Unable to fulfill delivery</span>
                                                <p class="text-gray-600 text-sm mt-1">Cannot deliver to customer's location</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Product damaged/defective" class="mt-1 mr-3 text-orange-600 focus:ring-orange-500" {{ old('cancellation_reason') == 'Product damaged/defective' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800">Product damaged/defective</span>
                                                <p class="text-gray-600 text-sm mt-1">Item cannot be shipped due to quality issues</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Payment verification failed" class="mt-1 mr-3 text-orange-600 focus:ring-orange-500" {{ old('cancellation_reason') == 'Payment verification failed' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800">Payment verification failed</span>
                                                <p class="text-gray-600 text-sm mt-1">Unable to verify customer payment</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Price error" class="mt-1 mr-3 text-orange-600 focus:ring-orange-500" {{ old('cancellation_reason') == 'Price error' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800">Pricing error</span>
                                                <p class="text-gray-600 text-sm mt-1">Incorrect pricing on the product</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Customer unreachable" class="mt-1 mr-3 text-orange-600 focus:ring-orange-500" {{ old('cancellation_reason') == 'Customer unreachable' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800">Customer unreachable</span>
                                                <p class="text-gray-600 text-sm mt-1">Unable to contact customer for order confirmation</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="other" class="mt-1 mr-3 text-orange-600 focus:ring-orange-500" id="seller-other-reason" {{ old('cancellation_reason') == 'other' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800">Other reason</span>
                                                <p class="text-gray-600 text-sm mt-1">I'll provide details below</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    @error('cancellation_reason')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Custom Reason Input -->
                                <div id="seller-custom-reason-input" style="display: {{ old('cancellation_reason') == 'other' ? 'block' : 'none' }};" class="mb-6">
                                    <label for="custom_cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                        Please specify the reason
                                    </label>
                                    <textarea 
                                        name="custom_cancellation_reason" 
                                        id="custom_cancellation_reason"
                                        rows="4" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none"
                                        placeholder="Please provide a clear explanation for the customer..."
                                    >{{ old('custom_cancellation_reason') }}</textarea>
                                    
                                    @error('custom_cancellation_reason')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Customer Message -->
                                <div class="mb-8">
                                    <label for="additional_comments" class="block text-sm font-medium text-gray-700 mb-2">
                                        Message to Customer
                                    </label>
                                    <textarea 
                                        name="additional_comments" 
                                        id="additional_comments"
                                        rows="4" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none"
                                        placeholder="Explain to the customer why you're cancelling their order and apologize for any inconvenience."
                                    >{{ old('additional_comments') }}</textarea>
                                    <p class="text-gray-500 text-xs mt-1">Optional</p>
                                    
                                    @error('additional_comments')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Refund Information -->
                                @if($order->payment_method !== 'cod')
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                        <div class="flex items-start">
                                            <span class="text-blue-500 text-lg mr-3 mt-0.5">💳</span>
                                            <div>
                                                <p class="text-blue-800 font-medium mb-1">Refund Information</p>
                                                <p class="text-blue-700 text-sm">
                                                    Since the customer paid via {{ ucfirst($order->payment_method) }}, a refund of 
                                                    <strong>RM{{ number_format($order->total, 2) }}</strong> will be processed automatically 
                                                    within 3-5 business days after cancellation.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Final Confirmation -->
                                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <span class="text-orange-500 text-lg mr-3 mt-0.5">⚠️</span>
                                        <div>
                                            <p class="text-orange-800 font-medium mb-1">Confirm Cancellation</p>
                                            <p class="text-orange-700 text-sm">
                                                By proceeding, you will cancel this order and the customer will be notified immediately. 
                                                This action cannot be reversed.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button 
                                        type="submit" 
                                        class="flex-1 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white font-bold py-4 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg text-center"
                                        onclick="return confirm('Are you sure you want to cancel this order? The customer will be notified and this action cannot be undone.')"
                                    >
                                        🚫 Cancel Order - RM{{ number_format($order->total, 2) }}
                                    </button>
                                    {{-- <a 
                                        href="{{ route('seller.orders.show', $order->id) }}"
                                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-4 px-6 rounded-lg transition-all duration-200 text-center"
                                    >
                                        Keep Order Active
                                    </a>
                                </div> --}}
                            </form>
                        </div>
                    </div>
                </div>

            @elseif($order->order_status == 'cancelled')
                <!-- Order Already Cancelled -->
                <div class="w-full max-w-3xl mx-auto">
                    <div class="bg-red-50 border border-red-200 rounded-xl p-8">
                        <div class="text-center mb-6">
                            <div class="text-red-500 text-6xl mb-4">❌</div>
                            <h2 class="text-2xl font-bold text-red-800 mb-4">Order Cancelled</h2>
                            <p class="text-red-700 mb-6">
                                This order was cancelled on {{ $order->updated_at->format('M d, Y \a\t g:i A') }}.
                            </p>
                        </div>

                        @if($order->cancellation_reason)
                            <div class="bg-white rounded-lg p-6 mb-6">
                                <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <span class="w-2 h-2 bg-red-600 rounded-full mr-3"></span>
                                    Cancellation Details
                                </h3>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Reason:</p>
                                        <p class="font-medium text-gray-900">{{ $order->cancellation_reason }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Customer:</p>
                                        <p class="font-medium text-gray-900">{{ optional($order->buyer)->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="text-center">
                            <a href="{{ route('seller.orders.index') }}" 
                               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                                View All Orders
                            </a>
                        </div>
                    </div>
                </div>

            @else
                <!-- Order Cannot Be Cancelled -->
                <div class="w-full max-w-2xl mx-auto">
                    <div class="bg-green-50 border border-green-200 rounded-xl p-8 text-center">
                        <div class="text-green-500 text-6xl mb-4">✅</div>
                        <h2 class="text-2xl font-bold text-green-800 mb-4">Order Completed</h2>
                        <p class="text-green-700 mb-6">
                            This order has been completed and delivered to the customer. 
                            Completed orders cannot be cancelled.
                        </p>
                        <a href="{{ route('seller.orders.index') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                            View All Orders
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otherReasonRadio = document.getElementById('seller-other-reason');
            const customReasonInput = document.getElementById('seller-custom-reason-input');
            const customTextarea = document.getElementById('custom_cancellation_reason');
            const allRadios = document.querySelectorAll('input[name="cancellation_reason"]');

            function toggleCustomReason() {
                if (otherReasonRadio && otherReasonRadio.checked) {
                    customReasonInput.style.display = 'block';
                    customTextarea.setAttribute('required', 'required');
                } else {
                    customReasonInput.style.display = 'none';
                    customTextarea.removeAttribute('required');
                    customTextarea.value = '';
                }
            }

            allRadios.forEach(function(radio) {
                radio.addEventListener('change', toggleCustomReason);
            });

            toggleCustomReason();
        });
    </script>
</x-layouts.app>