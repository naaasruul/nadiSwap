<x-layouts.app :title="__('List Of Orders')">
    <x-dashboard-header>List Of Order Payments</x-dashboard-header>

    {{-- <div class="container mx-auto p-5"> --}}
        {{-- <div class="overflow-x-auto relative shadow-md sm:rounded-lg"> --}}
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="admin-order-table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">Buyer Details</th>
                        <th scope="col" class="px-6 py-3">Seller</th>
                        <th scope="col" class="px-6 py-3">Items</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Payment Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->buyer->name ?? 'N/A' }} &bull; {{ $order->buyer->phone_number ?? 'N/A' }}</td>
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
                                    $statusClasses = match ($order->payment_status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $statusClasses }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('seller.orders.show-payment', $order->id) }}" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        {{-- </div> --}}
    {{-- </div> --}}

    @push('js')
        <script src="{{ asset('js/admin-payment-table.js') }}"></script>
    @endpush
</x-layouts.app>