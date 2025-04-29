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
                        Buyer ID
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
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr data-id="{{ $order->id }}" class="product-row">
                <td>{{ $loop->iteration }}</td>
                <td data-tooltip-target="tooltip-{{ $order->id }}"
                    class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $order->id }}
                    @push('modal')
                    <div id="tooltip-{{ $order->id }}" role="tooltip"
                        class="absolute invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                        @php
                            $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
                        @endphp
                        @if (is_array($items))
                            @foreach ($items as $item)
                                @if (is_array($item))
                                    - {{ $item['name'] ?? 'Unknown Product' }} <br>
                                @elseif (is_object($item))
                                    {{ $item->name ?? 'Unknown Product' }} <br>
                                @else
                                    {{ $item }} <br>
                                @endif
                            @endforeach
                        @else
                            <span>No items available</span>
                        @endif
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    @endpush
                </td>
                <td>{{ $order->buyer->id }}</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                <td>RM{{ number_format($order->total, 2) }}</td>
                <td>{{ $order->payment_method }}</td>
                <td>
                    <select  data-id="{{ $order->id }}" class="payment-status-dropdown bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                      </select>
                </td>
                <td>
                    <select  data-id="{{ $order->id }}" class="delivery-status-dropdown bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="Pending" {{ $order->delivery_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Shipped" {{ $order->delivery_status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="Delivered" {{ $order->delivery_status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="Cancelled" {{ $order->delivery_status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                      </select>
            </tr>
            @endforeach
        </tbody>
    </table>

    @push('js')
        <script src="{{ asset( 'js/order-table.js') }}"></script>
        <script src="{{asset('js/update-order-status.js')}}"></script>
    @endpush

    </x-layouts-app>