<x-layouts.app :title="__('Transactions')">
    <x-dashboard-header>Transactions</x-dashboard-header>

    <div class="container mx-auto p-5">
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Order ID</th>
                        <th scope="col" class="px-6 py-3">Buyer</th>
                        <th scope="col" class="px-6 py-3">Seller</th>
                        <th scope="col" class="px-6 py-3">Items</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->buyer->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $order->seller->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <ul>
                                    @php
                                        $items = json_decode($order->items, true); // Decode the items JSON
                                    @endphp
                                    @if (is_array($items) && isset($items['cart_items']))
                                        @foreach ($items['cart_items'] as $item)
                                            <li>{{ $item['name'] }} (x{{ $item['quantity'] }})</li>
                                        @endforeach
                                    @else
                                        <li>No items available</li>
                                    @endif
                                </ul>
                            </td>
                            <td class="px-6 py-4">RM{{ number_format($order->total, 2) }}</td>
                            {{-- <td class="px-6 py-4">
                                <a href="{{ route('admin.transactions.index', $order->id) }}" class="text-pink-600 hover:underline">View</a>
                            </td> --}}
                            <td class="px-6 py-4">{{ $order->created_at->format('l, F j, Y - g:i A')  ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>