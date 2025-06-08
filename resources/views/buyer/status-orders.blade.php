<x-layouts.customer-layout :title="__('List Of Orders')">
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12 mx-auto max-w-screen-xl px-4 2xl:px-0">

        <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
            Orders
        </h2>

        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="buyer-order-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">No.</th>
                    <th scope="col" class="px-6 py-3">Order ID</th>
                    <th scope="col" class="px-6 py-3">Buyer</th>
                    <th scope="col" class="px-6 py-3">Seller</th>
                    <th scope="col" class="px-6 py-3">Items</th>
                    <th scope="col" class="px-6 py-3">Total</th>
                    <th scope="col" class="px-6 py-3">Payment Status</th>
                    <th scope="col" class="px-6 py-3">Delivery Status</th>
                    <th scope="col" class="px-6 py-3">Order Status</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">{{ $order->id }}</td>
                    <td class="px-6 py-4">{{ $order->buyer->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $order->seller->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <ul>
                            @php
                            $items = json_decode($order->items, true); // Decode the JSON string into an array
                            @endphp

                            @if (is_array($items['cart_items']))
                            @foreach ($items['cart_items'] as $item)
                            <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                            @endforeach
                            @else
                            <li>No items available</li>
                            @endif
                        </ul>
                    </td>
                    <td class="px-6 py-4">RM{{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-4">
                        @php
                        $paymentStatusClasses = match ($order->payment_status ?? 'pending') {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'paid' => 'bg-green-100 text-green-800',
                            'failed' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                        @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded {{ $paymentStatusClasses }}">
                            {{ ucfirst($order->payment_status ?? 'pending') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $deliveryStatusClasses = match ($order->delivery_status ?? 'pending') {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'shipped' => 'bg-blue-100 text-blue-800',
                            'ofd' => 'bg-purple-100 text-purple-800',
                            'delivered' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                        @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded {{ $deliveryStatusClasses }}">
                            {{ $order->delivery_status === 'ofd' ? 'Out for Delivery' : ucfirst($order->delivery_status ?? 'pending') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                        $orderStatusClasses = match ($order->order_status) {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800',
                        };
                        @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded {{ $orderStatusClasses }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('buyer.orders.show-status', $order->id) }}"
                            class="text-blue-600 hover:underline">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    @push('js')
    <script>
        // Pass PHP filters to JavaScript
        window.urlFilters = @json($filters);
    </script>
    <script src="{{ asset('js/buyer-order-table.js') }}"></script>
    @endpush
</x-layouts.customer-layout>