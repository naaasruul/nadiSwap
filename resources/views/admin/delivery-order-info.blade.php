<x-layouts.app :title="__('Order Details')">
    <div class="min-h-screen bg-gray-50">
        <!-- Header with Order Status -->
        @php
            $statusConfig = match ($order->delivery_status) {
                'shipped' => [
                    'text' => 'Shipped', 
                    'bg' => 'bg-yellow-500', 
                    'icon' => '🚚',
                    'headerGradient' => 'bg-gradient-to-r from-yellow-500 to-orange-600',
                    'textColor' => 'text-yellow-100'
                ],
                'ofd' => [
                    'text' => 'Out for Delivery', 
                    'bg' => 'bg-blue-500', 
                    'icon' => '🚛',
                    'headerGradient' => 'bg-gradient-to-r from-blue-600 to-indigo-700',
                    'textColor' => 'text-blue-100'
                ],
                'delivered' => [
                    'text' => 'Delivered', 
                    'bg' => 'bg-green-500', 
                    'icon' => '✅',
                    'headerGradient' => 'bg-gradient-to-r from-green-600 to-emerald-700',
                    'textColor' => 'text-green-100'
                ],
                'cancelled' => [
                    'text' => 'Cancelled', 
                    'bg' => 'bg-red-500', 
                    'icon' => '❌',
                    'headerGradient' => 'bg-gradient-to-r from-red-600 to-red-700',
                    'textColor' => 'text-red-100'
                ],
                default => [
                    'text' => 'Processing', 
                    'bg' => 'bg-gray-500', 
                    'icon' => '⏳',
                    'headerGradient' => 'bg-gradient-to-r from-gray-600 to-slate-700',
                    'textColor' => 'text-gray-100'
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

        <div class="container mx-auto px-4 py-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Progress Timeline -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold mb-6 flex items-center">
                            <span class="w-2 h-2 bg-blue-600 rounded-full mr-3"></span>
                            Order Progress
                        </h2>
                        <div class="relative">
                            @php
                                $steps = [
                                    ['key' => 'processing', 'label' => 'Order Confirmed', 'icon' => '📋'],
                                    ['key' => 'shipped', 'label' => 'Shipped', 'icon' => '📦'],
                                    ['key' => 'ofd', 'label' => 'Out for Delivery', 'icon' => '🚛'],
                                    ['key' => 'delivered', 'label' => 'Delivered', 'icon' => '🏠'],
                                    ['key' => 'cancelled', 'label' => 'Cancelled', 'icon' => '❌']
                                ];
                                
                                $currentStep = array_search($order->delivery_status, array_column($steps, 'key'));
                                if ($currentStep === false) $currentStep = 0;
                                $isCancelled = $order->delivery_status === 'cancelled';
                            @endphp
                            
                            <div class="flex items-center justify-between relative">
                                <!-- Progress Line -->
                                @if(!$isCancelled)
                                    <div class="absolute top-6 left-6 right-6 h-0.5 bg-gray-200">
                                        <div class="h-full bg-gradient-to-r from-blue-500 to-green-500 transition-all duration-500" 
                                             style="width: {{ $order->delivery_status == 'delivered' ? '100' : ($currentStep * 25) }}%"></div>
                                    </div>
                                @else
                                    <!-- Cancelled state - red line -->
                                    <div class="absolute top-6 left-6 right-6 h-0.5 bg-red-200">
                                        <div class="h-full bg-red-500 transition-all duration-500 w-full"></div>
                                    </div>
                                @endif
                                
                                @if(!$isCancelled)
                                    @foreach(array_slice($steps, 0, 4) as $index => $step)
                                        <div class="relative flex flex-col items-center">
                                            <div class="w-12 h-12 rounded-full border-4 flex items-center justify-center text-lg z-10
                                                {{ $index <= $currentStep || $order->delivery_status == $step['key'] 
                                                   ? 'bg-blue-600 border-blue-600 text-white' 
                                                   : 'bg-white border-gray-300' }}">
                                                {{ $step['icon'] }}
                                            </div>
                                            <p class="text-sm font-medium mt-2 text-center
                                                {{ $index <= $currentStep || $order->delivery_status == $step['key'] 
                                                   ? 'text-blue-600' 
                                                   : 'text-gray-500' }}">
                                                {{ $step['label'] }}
                                            </p>
                                        </div>
                                    @endforeach
                                @else
                                    <!-- Cancelled Timeline -->
                                    <div class="w-full flex justify-center">
                                        <div class="relative flex flex-col items-center">
                                            <div class="w-16 h-16 rounded-full border-4 bg-red-600 border-red-600 text-white flex items-center justify-center text-2xl z-10">
                                                ❌
                                            </div>
                                            <p class="text-lg font-semibold mt-3 text-center text-red-600">
                                                Order Cancelled
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1 text-center">
                                                This order has been cancelled and will not be processed
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Details -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold mb-6 flex items-center">
                            <span class="w-2 h-2 bg-green-600 rounded-full mr-3"></span>
                            Items Ordered
                        </h2>
                        @php
                            $items = json_decode($order->items, true);
                            $cartItems = $items['cart_items'] ?? [];
                            $shippingTotal = $items['shipping_total'] ?? 0;
                        @endphp
                        
                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <div class="w-20 h-20 bg-white rounded-lg overflow-hidden shadow-sm mr-4">
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}" 
                                             class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-1">{{ $item['name'] }}</h3>
                                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                                            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                                Quantity: {{ $item['quantity'] }}
                                            </span>
                                            <span class="font-semibold text-gray-900">RM{{ number_format($item['price'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Summary -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="space-y-3">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>RM{{ number_format($order->total - $shippingTotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span>RM{{ number_format($shippingTotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold text-gray-900 pt-3 border-t border-gray-200">
                                    <span>Total</span>
                                    <span>RM{{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Payment Status Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold mb-4 flex items-center">
                            <span class="w-2 h-2 bg-purple-600 rounded-full mr-3"></span>
                            Payment Status
                        </h3>
                        <div class="flex items-center justify-between">
                            <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $order->payment_status == 'paid' ? '✅ Paid' : '❌ Unpaid' }} {{ $order->payment_status == 'cancelled' ? '' : 'via ' }} {{ ucfirst($order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Banking' ) }}
                            </span>
                        </div>
                    </div>

                    <!-- Delivery Address Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold mb-4 flex items-center">
                            <span class="w-2 h-2 bg-red-600 rounded-full mr-3"></span>
                            Delivery Address
                        </h3>
                        @php
                            $address_id = $items['delivery_address_id'] ?? null;
                            $address = \App\Models\DeliveryAddress::find($address_id);
                        @endphp
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start">
                                <span class="text-2xl mr-3">📍</span>
                                <div>
                                    <p class="font-semibold text-gray-900 mb-1">{{ optional($order->buyer)->name ?? 'N/A' }}</p>
                                    <p class="text-gray-600 text-sm mb-2">{{ optional($order->buyer)->phone_number ?? 'N/A' }}</p>
                                    <p class="text-gray-700 leading-relaxed">
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

                    <!-- Seller Information Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h3 class="font-semibold mb-4 flex items-center">
                            <span class="w-2 h-2 bg-orange-600 rounded-full mr-3"></span>
                            Seller Information
                        </h3>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-4">
                                {{ substr(optional($order->seller)->name ?? 'N', 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ optional($order->seller)->name ?? 'N/A' }}</p>
                                <p class="text-gray-600 text-sm">{{ optional($order->seller)->phone_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        {{-- @if($order->delivery_status !== 'delivered' && $order->delivery_status !== 'cancelled')
                            <button class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                                Cancel Order
                            </button>
                        @endif --}}
                        
                        {{-- <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                            Contact Seller
                        </button> --}}
                        
                        {{-- @if($order->delivery_status === 'delivered')
                            <button class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-md">
                                Leave Review
                            </button>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>