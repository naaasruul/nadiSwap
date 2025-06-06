<x-layouts.app :title="__('Payment Status')">
    <div class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12 mx-auto max-w-screen-xl px-4 2xl:px-0">
        <!-- Header -->
        @php
            $statusConfig = match ($order->order_status) {
                'completed' => [
                    'text' => 'Delivered', 
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
                    'headerGradient' => 'bg-gradient-to-r from-yellow-600 to-yellow-700',
                    'borderColor' => 'border-yellow-300',
                    'textColor' => 'text-yellow-100'
                ],
            };
        @endphp
        <div class="{{ $statusConfig['headerGradient'] }} text-white rounded-lg">
            <div class="container mx-auto p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2 dark:text-gray-100">Order #{{ $order->id }}</h1>
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

        <div class="container mx-auto px-4 py-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Payment Status Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 dark:bg-gray-800 dark:border-gray-700">
                        <h2 class="text-lg font-semibold mb-6 flex items-center dark:text-gray-100">
                            <span class="w-2 h-2 bg-purple-600 rounded-full mr-3"></span>
                            Order Status
                        </h2>
                        <div class="bg-gray-50 rounded-lg p-6 dark:bg-gray-700">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl
                                        {{ match($order->order_status) {
                                            'completed' => 'bg-green-100 text-green-600 dark:bg-green-600 dark:text-green-100',
                                            'pending' => 'bg-yellow-100 text-yellow-600 dark:bg-yellow-600 dark:text-yellow-100',
                                            'cancelled' => 'bg-red-100 text-red-600 dark:bg-red-600 dark:text-red-100',
                                            default => 'bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-100'
                                        } }}">
                                        {{ match($order->order_status) {
                                            'completed' => '✅',
                                            'pending' => '⏳',
                                            'cancelled' => '❌',
                                            default => '❓'
                                        } }}
                                    </div>
                                    <div>
                                        <p class="text-xl font-bold
                                            {{ match($order->order_status) {
                                                'completed' => 'text-green-600 dark:text-green-400',
                                                'pending' => 'text-yellow-600 dark:text-yellow-400',
                                                'cancelled' => 'text-red-600 dark:text-red-400',
                                                default => 'text-gray-600 dark:text-gray-400'
                                            } }}">
                                            {{ match($order->order_status) {
                                                'completed' => 'Order Completed',
                                                'pending' => 'Order Pending',
                                                'cancelled' => 'Order Cancelled',
                                                default => 'Unknown Status'
                                            } }}
                                        </p>

                                        @if($order->order_status == 'completed')
                                            <p class="text-gray-600 mt-1 dark:text-gray-300">
                                                {{ $order->order_status == 'completed' ? 'Paid' : '' }} {{ $order->order_status == 'cancelled' ? '' : 'via ' }} {{ ucfirst($order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Banking' ) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">RM{{ number_format($order->total, 2) }}</p>
                                    <p class="text-gray-500 text-sm dark:text-gray-400">Total Amount</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 dark:bg-gray-800 dark:border-gray-700">
                        <h2 class="text-lg font-semibold mb-6 flex items-center dark:text-gray-100">
                            <span class="w-2 h-2 bg-green-600 rounded-full mr-3"></span>
                            Product
                        </h2>
                        
                        <!-- Seller Information -->
                        <div class="mb-6 bg-gray-50 rounded-lg p-4 dark:bg-gray-700">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                    {{ substr(optional($order->seller)->name ?? 'N', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ optional($order->seller)->name ?? 'N/A' }}</p>
                                    <p class="text-gray-600 text-sm dark:text-gray-300">{{ optional($order->seller)->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Product Items -->
                        @php
                            $items = json_decode($order->items, true);
                            $cartItems = $items['cart_items'] ?? [];
                            $shippingTotal = $items['shipping_total'] ?? 0;
                        @endphp
                        
                        <div class="space-y-4">
                            @foreach($cartItems as $productId => $item)
                                @php
                                    $product = \App\Models\Product::find($productId);
                                @endphp
                                <a href="{{ route('products.show', $productId) }}" class="flex items-start p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors dark:bg-gray-700 dark:hover:bg-gray-600">
                                    <div class="w-20 h-20 bg-white rounded-lg overflow-hidden shadow-sm mr-4 dark:bg-gray-800">
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-1 dark:text-gray-100">{{ $item['name'] }}</h3>
                                        <p class="text-gray-600 text-sm mb-2 leading-relaxed dark:text-gray-300">
                                            {{ $product->description ?? 'No description available' }}
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium dark:bg-blue-900 dark:text-blue-300">
                                                Quantity: {{ $item['quantity'] }}
                                            </span>
                                            <span class="font-bold text-gray-900 dark:text-gray-100 text-lg">RM{{ number_format($item['price'], 2) }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Shipping Fee -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between bg-blue-50 rounded-lg p-4 dark:bg-blue-900">
                                <div class="flex items-center">
                                    <span class="text-xl mr-3">🚚</span>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">Shipping Fee</p>
                                        <p class="text-gray-600 text-sm dark:text-gray-300"></p>
                                    </div>
                                </div>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100">RM{{ number_format($shippingTotal, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Delivery Information Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="font-semibold mb-4 flex items-center dark:text-gray-100">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            Delivery Information
                        </h3>
                        
                        <!-- Buyer Details -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-3 dark:text-gray-300">Buyer Details</h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 dark:text-gray-400">Name</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ optional($order->buyer)->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 dark:text-gray-400">Phone Number</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ optional($order->buyer)->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Address -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-3 dark:text-gray-300">Delivery Address</h4>
                            @php
                                $address_id = $items['delivery_address_id'] ?? null;
                                $address = \App\Models\DeliveryAddress::find($address_id);
                            @endphp
                            <div class="bg-gray-50 rounded-lg p-4 dark:bg-gray-700">
                                <div class="flex items-start">
                                    <span class="text-lg mr-3 mt-1">📍</span>
                                    <p class="text-gray-700 leading-relaxed text-sm dark:text-gray-300">
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

                    <!-- Order Information Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="font-semibold mb-4 flex items-center dark:text-gray-100">
                            <span class="w-2 h-2 bg-orange-600 rounded-full mr-3"></span>
                            Order Information
                        </h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <span class="text-xl mr-3">📋</span>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 dark:text-gray-400">Order ID</p>
                                    <p class="font-bold text-gray-900 dark:text-gray-100">#{{ $order->id }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xl mr-3">📅</span>
                                <div>
                                    <p class="text-xs text-gray-500 mb-1 dark:text-gray-400">Order Date & Time</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-gray-600 text-xs dark:text-gray-300">{{ $order->created_at->format('g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Summary Card -->
                    <div class="{{ $statusConfig['headerGradient'] }} text-white rounded-xl p-6">
                        <h3 class="font-semibold mb-3 dark:text-gray-100">Order Summary</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-blue-100">Subtotal</span>
                                <span>RM{{ number_format($order->total - $shippingTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-blue-100">Shipping</span>
                                <span>RM{{ number_format($shippingTotal, 2) }}</span>
                            </div>
                            <div class="border-t {{ $statusConfig['borderColor'] }} pt-2 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold dark:text-gray-100">Total</span>
                                    <span class="text-xl font-bold dark:text-gray-100">RM{{ number_format($order->total, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between {{ $order->file_receipt ? 'mt-2' : '' }}">
                                    <p class="text-blue-100 text-xs">
                                        {{ $order->order_status == 'completed' ? 'Payment Completed' : ($order->order_status == 'pending' ? 'Payment Pending' : ($order->order_status == 'cancelled' ? 'Order Cancelled' : '')) }}
                                    </p>
                                    @if($order->file_receipt)
                                        <a href="{{ asset('storage/' . $order->file_receipt) }}" 
                                           class="inline-flex items-center text-white hover:text-blue-200"
                                           target="_blank"
                                           download>
                                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download Receipt
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    {{-- <div class="space-y-3">
                        <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                            Download Receipt
                        </button>
                        
                        <button class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                            Contact Support
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>