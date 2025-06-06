<x-layouts.customer-layout>
    <div class="bg-gray-50 dark:bg-gray-900 py-8 antialiased md:py-12 mx-auto max-w-screen-xl px-4 2xl:px-0">
        <!-- Header -->
        @php
            $statusConfig = match ($order->order_status) {
                'completed' => [
                    'text' => 'Delivered', 
                    'bg' => 'bg-green-500', 
                    'icon' => '✅',
                    'headerGradient' => 'bg-gradient-to-r from-green-600 to-emerald-700',
                    'borderColor' => 'border-green-300 dark:border-green-600',
                    'textColor' => 'text-green-100'
                ],
                'cancelled' => [
                    'text' => 'Failed', 
                    'bg' => 'bg-red-500', 
                    'icon' => '❌',
                    'headerGradient' => 'bg-gradient-to-r from-red-600 to-red-700',
                    'borderColor' => 'border-red-300 dark:border-red-600',
                    'textColor' => 'text-red-100'
                ],
                default => [
                    'text' => 'Pending', 
                    'bg' => 'bg-yellow-500', 
                    'icon' => '⏳',
                    'headerGradient' => 'bg-gradient-to-r from-yellow-600 to-yellow-700',
                    'borderColor' => 'border-yellow-300 dark:border-yellow-600',
                    'textColor' => 'text-yellow-100'
                ],
            };
        @endphp
        <div class="{{ $statusConfig['headerGradient'] }} text-white rounded-lg">
            <div class="container mx-auto p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Order #{{ $order->id }}</h1>
                        <p class="{{ $statusConfig['textColor'] }}">Placed on {{ $order->created_at->format('M d, Y') }}</p>
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
                                <p class="{{ $statusConfig['textColor'] }} text-sm mt-1">Current Status</p>
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
                    <!-- Cancellation Notice -->
                    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-6 mb-8 rounded-r-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span class="text-red-500 text-2xl">⚠️</span>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-xl font-bold text-red-800 dark:text-red-200 mb-2">Cancel Your Order</h2>
                                <p class="text-red-700 dark:text-red-300">
                                    You're about to cancel order #{{ $order->id }}. Once cancelled, this action cannot be undone. 
                                    Please review your order details below and provide a reason for cancellation.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2 gap-8">
                        <!-- Left Column: Order Summary for Review -->
                        <div class="space-y-6">
                            <!-- Order Items Review -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-800 dark:text-gray-200">
                                    <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                                    Order Summary
                                </h3>
                                
                                @php
                                    $items = json_decode($order->items, true);
                                    $cartItems = $items['cart_items'] ?? [];
                                    $shippingTotal = $items['shipping_total'] ?? 0;
                                @endphp
                                
                                <div class="space-y-4 mb-6">
                                    @foreach($cartItems as $productId => $item)
                                        <div class="flex items-center p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="w-16 h-16 bg-white dark:bg-gray-600 rounded-lg overflow-hidden shadow-sm mr-4">
                                                <img src="{{ asset('storage/' . $item['image']) }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="w-full h-full object-cover">
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</h4>
                                                <div class="flex items-center justify-between mt-1">
                                                    <span class="text-sm text-gray-600 dark:text-gray-300">Qty: {{ $item['quantity'] }}</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">RM{{ number_format($item['price'], 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Order Total -->
                                <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600 dark:text-gray-300">Subtotal</span>
                                        <span class="text-gray-900 dark:text-white">RM{{ number_format($order->total - $shippingTotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm mb-3">
                                        <span class="text-gray-600 dark:text-gray-300">Shipping</span>
                                        <span class="text-gray-900 dark:text-white">RM{{ number_format($shippingTotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between text-lg font-bold text-red-600 dark:text-red-400 border-t border-gray-200 dark:border-gray-600 pt-3">
                                        <span>Total to Cancel</span>
                                        <span>RM{{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Info -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                                <h3 class="text-lg font-semibold mb-4 flex items-center text-gray-800 dark:text-gray-200">
                                    <span class="w-2 h-2 bg-green-600 rounded-full mr-3"></span>
                                    Delivery Details
                                </h3>
                                
                                @php
                                    $address_id = $items['delivery_address_id'] ?? null;
                                    $address = \App\Models\DeliveryAddress::find($address_id);
                                @endphp
                                
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Delivery To</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ optional($order->buyer)->name ?? 'N/A' }}</p>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm">{{ optional($order->buyer)->phone_number ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Address</p>
                                        <p class="text-gray-700 dark:text-gray-300 text-sm">
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
                            </div>
                        </div>

                        <!-- Right Column: Cancellation Form -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border-l-4 border-l-red-500 p-6">
                            <h3 class="text-xl font-bold text-red-700 dark:text-red-400 mb-6 flex items-center">
                                <span class="mr-3">❌</span>
                                Cancellation Form
                            </h3>

                            <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" id="cancellation-form">
                                @csrf
                                @method('PATCH')
                                
                                <!-- Reason Selection -->
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-800 dark:text-gray-200 mb-4">
                                        Why are you cancelling this order? <span class="text-red-500">*</span>
                                    </label>
                                    
                                    <div class="space-y-3">
                                        <label class="flex items-start p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Changed my mind" class="mt-1 mr-3 text-red-600 focus:ring-red-500" {{ old('cancellation_reason') == 'Changed my mind' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200">Changed my mind</span>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">I no longer need this item</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Found better price elsewhere" class="mt-1 mr-3 text-red-600 focus:ring-red-500" {{ old('cancellation_reason') == 'Found better price elsewhere' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200">Found better price elsewhere</span>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">I found a better deal somewhere else</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Ordered by mistake" class="mt-1 mr-3 text-red-600 focus:ring-red-500" {{ old('cancellation_reason') == 'Ordered by mistake' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200">Ordered by mistake</span>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">This was an accidental purchase</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Payment issues" class="mt-1 mr-3 text-red-600 focus:ring-red-500" {{ old('cancellation_reason') == 'Payment issues' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200">Payment issues</span>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">I'm having trouble with payment</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="Delivery too slow" class="mt-1 mr-3 text-red-600 focus:ring-red-500" {{ old('cancellation_reason') == 'Delivery too slow' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200">Delivery taking too long</span>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">I need this item sooner</p>
                                            </div>
                                        </label>
                                        
                                        <label class="flex items-start p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                            <input type="radio" name="cancellation_reason" value="other" class="mt-1 mr-3 text-red-600 focus:ring-red-500" id="other-reason" {{ old('cancellation_reason') == 'other' ? 'checked' : '' }}>
                                            <div>
                                                <span class="font-medium text-gray-800 dark:text-gray-200">Other reason</span>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">I'll specify below</p>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    @error('cancellation_reason')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Custom Reason Input -->
                                <div id="custom-reason-input" style="display: {{ old('cancellation_reason') == 'other' ? 'block' : 'none' }};" class="mb-6">
                                    <label for="custom_cancellation_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Please specify your reason
                                    </label>
                                    <textarea 
                                        name="custom_cancellation_reason" 
                                        id="custom_cancellation_reason"
                                        rows="4" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none"
                                        placeholder="Please provide details about your cancellation reason..."
                                    >{{ old('custom_cancellation_reason') }}</textarea>
                                    
                                    @error('custom_cancellation_reason')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Additional Comments -->
                                <div class="mb-8">
                                    <label for="additional_comments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Additional Comments (Optional)
                                    </label>
                                    <textarea 
                                        name="additional_comments" 
                                        id="additional_comments"
                                        rows="3" 
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none"
                                        placeholder="Any additional information you'd like to share..."
                                    >{{ old('additional_comments') }}</textarea>
                                </div>

                                <!-- Final Confirmation -->
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg p-4 mb-6">
                                    <div class="flex items-start">
                                        <span class="text-red-500 text-lg mr-3 mt-0.5">⚠️</span>
                                        <div>
                                            <p class="text-red-800 dark:text-red-200 font-medium mb-1">Final Confirmation</p>
                                            <p class="text-red-700 dark:text-red-300 text-sm">
                                                By clicking "Cancel Order", you confirm that you want to cancel this order. 
                                                This action is permanent and cannot be reversed.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button 
                                        type="submit" 
                                        class="flex-1 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold py-4 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg text-center"
                                        onclick="return confirm('Are you absolutely sure you want to cancel this order? This action cannot be undone.')"
                                    >
                                        🗑️ Cancel Order - RM{{ number_format($order->total, 2) }}
                                    </button>
                                    <a 
                                        href="{{ route('buyer.orders.show-status', $order->id) }}"
                                        class="flex-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 font-medium py-4 px-6 rounded-lg transition-all duration-200 text-center"
                                    >
                                        Keep Order
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @elseif($order->order_status == 'cancelled')
                <!-- Order Already Cancelled -->
                <div class="w-full max-w-2xl mx-auto">
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-xl p-8 text-center">
                        <div class="text-red-500 text-6xl mb-4">❌</div>
                        <h2 class="text-2xl font-bold text-red-800 dark:text-red-200 mb-4">Order Cancelled</h2>
                        <p class="text-red-700 dark:text-red-300 mb-6">
                            This order was cancelled on {{ $order->updated_at->format('M d, Y \a\t g:i A') }}.
                        </p>
                        @if($order->cancellation_reason)
                            <div class="bg-white dark:bg-gray-700 rounded-lg p-4 mb-6">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Cancellation Reason:</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $order->cancellation_reason }}</p>
                            </div>
                        @endif
                        <a href="{{ route('buyer.orders.index') }}" 
                           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                            View All Orders
                        </a>
                    </div>
                </div>

            @else
                <!-- Order Cannot Be Cancelled -->
                <div class="w-full max-w-2xl mx-auto">
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-xl p-8 text-center">
                        <div class="text-green-500 text-6xl mb-4">✅</div>
                        <h2 class="text-2xl font-bold text-green-800 dark:text-green-200 mb-4">Order Completed</h2>
                        <p class="text-green-700 dark:text-green-300 mb-6">
                            This order has been completed and cannot be cancelled. 
                            If you have any issues, please contact customer support.
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otherReasonRadio = document.getElementById('other-reason');
            const customReasonInput = document.getElementById('custom-reason-input');
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
</x-layouts.customer-layout>