<x-layouts.app :title="__('List Of Orders')">
    <x-dashboard-header>List Of Order Deliveries</x-dashboard-header>

    {{-- <div class="container mx-auto p-5"> --}}
        {{-- <div class="overflow-x-auto relative shadow-md sm:rounded-lg"> --}}
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" id="admin-order-table">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">No.</th>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">Buyer</th>
                        <th scope="col" class="px-6 py-3">Seller</th>
                        <th scope="col" class="px-6 py-3">Items</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Delivery Status</th>
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
                            @php
                                $statusClasses = match ($order->delivery_status) {
                                    'shipped' => 'bg-blue-100 text-blue-800',
                                    'ofd' => 'bg-purple-100 text-purple-800',
                                    'delivered' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                };
                            @endphp
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $statusClasses }}">
                                    {{ $order ? $order->delivery_status == 'ofd' ? 'Out for Delivery' : ucfirst($order->delivery_status) : 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show-delivery', $order->id) }}" class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        {{-- </div> --}}
    {{-- </div> --}}

    @push('js')
        <script src="{{ asset('js/admin-delivery-table.js') }}"></script>
    @endpush
</x-layouts.app>