<x-layouts.app :title="__('Orders')">
    <x-dashboard-header>Orders</x-dashboard-header>

    {{-- @if (session('success'))
    <div class="p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
        role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="p-4 my-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif --}}
    <div class="alert-message"></div>
    {{-- js/order-table.js --}}
    <table id="order-table" class="relative z-0">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        #
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Order ID
                        <i class="fa-solid fa-sort ms-3"></i>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Buyer Details
                        <i class="fa-solid fa-sort ms-3"></i>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Date Ordered
                        <i class="fa-solid fa-sort ms-3"></i>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Price
                        <i class="fa-solid fa-sort ms-3"></i>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Payment Method
                        <i class="fa-solid fa-sort ms-3"></i>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Payment Status
                        <i class="fa-solid fa-sort ms-3"></i>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Delivery Status
                        <i class="fa-solid fa-sort ms-3"></i>
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Receipt
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Order Status
                    </span>
                </th>
                <th scope="col" class="px-6 py-3">
                    <span class="flex items-center">
                        Actions
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr data-id="{{ $order->id }}" class="product-row">
                <td>{{ $loop->iteration }}</td>
                <td data-tooltip-target="tooltip-{{ $order->id }}"
                    class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{-- <a href="{{ route('seller.orders.show-status', $order->id) }}"
                        class="hover:underline focus:ring-0 focus:outline-none inline-flex items-center bg-primary-700 text-blue-500 hover:bg-primary-800 font-medium rounded-lg text-sm py-2 dark:bg-primary-600 dark:hover:bg-primary-700">
                            {{ $order->id }}
                        </a> --}}
                            {{ $order->id }}
                    @push('modal')
                    <div id="tooltip-{{ $order->id }}" role="tooltip"
                        class="absolute invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">

                        @php
                            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
                        @endphp
                        {{ Log::debug($items); }}
                        @if (is_array($items['cart_items']))
                            @foreach ($items['cart_items'] as $item)
                                @if (is_array($item))
                                    {{ $item['name'] ?? 'Unknown Product' }} <br>
                                @elseif (is_object($item))
                                    {{ $item->name ?? 'Unknown Product' }} <br>
                                @else
                                    {{ $item }} <br>
                                @endif
                            @endforeach
                        @else
                            <span> No items available </span>
                        @endif
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    @endpush
                </td>
                <td>{!! '@' . $order->buyer->username !!} &bull; {{ $order->buyer->name }} &bull; {{ $order->buyer->phone_number }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td>RM{{ number_format($order->total, 2) }}</td>
                <td>{{ $order->payment_method === 'cod' ? 'Cash On Delivery' : 'Online Banking' }}</td>
                <td>
                    <select  data-id="{{ $order->id }}" class="payment-status-dropdown bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-500 dark:focus:border-pink-500">
                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }} disabled>Pending</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </td>
                <td>
                    <select  data-id="{{ $order->id }}" class="delivery-status-dropdown bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-500 dark:focus:border-pink-500">
                        <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }} disabled>Pending</option>
                        <option value="shipped" {{ $order->delivery_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="ood" {{ $order->delivery_status == 'ofd' ? 'selected' : '' }}>Out For Delivery</option>
                        <option value="delivered" {{ $order->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->delivery_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </td>
                <td>
                    @if ($order->file_receipt)
                        <a href="{{ asset('storage/' . $order->file_receipt) }}" class="text-blue-500 hover:underline" target="_blank" download>
                            <i class="fa-solid fa-xl text-accent fa-file-arrow-down"></i>
                        </a>
                    @else
                        <span class="text-gray-500">No Receipt</span>
                    @endif
                </td>
                <td>
                    <select data-id="{{ $order->id }}" class="{{ ($order->order_status == 'cancelled' || $order->order_status == 'completed') ? 'cursor-not-allowed opacity-50' : '' }} order-status-dropdown bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-500 dark:focus:border-pink-500" {{ $order->order_status == 'cancelled' || $order->order_status == 'completed' ? 'disabled' : '' }}>
                        <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }} disabled>Pending</option>
                        <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="request-cancel" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </td>
                <td>
                    <a href="{{ route('seller.orders.show-status', $order->id) }}" class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @push('js')
        <script src="{{ asset( 'js/order-table.js') }}"></script>
        <script src="{{asset('js/update-order-status.js')}}"></script>
    @endpush

    </x-layouts-app>