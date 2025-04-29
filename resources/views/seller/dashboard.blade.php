<x-layouts.app :title="__('Seller Dashboard')">
    <x-dashboard-header>Seller Dashboard</x-dashboard-header>

	@if (session('success'))
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
	@endif

    
    {{-- Dashboard Summary Cards --}}
    <div class="mx-auto max-w-screen-xl px-4 py-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
			<x-card title="Products" content="{{ $totalProducts }}" />
			<x-card title="Customers" content="{{ $totalBuyers }}" />
			<x-card title="Orders Today" content="{{ $newOrdersToday }}" />
            <x-card title="Sales" content="{!! 'RM ' . number_format($totalSales, 2) !!}" />
        </div>
    </div>

    {{-- Recent Orders Table --}}
    <div class="mx-auto max-w-screen-xl px-4 pb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-8 overflow-x-auto">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Orders</h2>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Order ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Customer ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Purchase Date</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Paid Amount</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tracking</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach(\App\Models\Order::latest()->take(10)->get() as $order)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->buyer_id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">RM{{ number_format($order->total, 2) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->status }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">
                                <form method="POST" action="{{ route('seller.orders.update-tracking', $order->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="tracking_status" class="rounded border-gray-300 dark:bg-gray-700 dark:text-white" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->tracking_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="shipped" {{ $order->tracking_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $order->tracking_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->tracking_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delivery Progress Table --}}
    <div class="mx-auto max-w-screen-xl px-4 pb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-8 overflow-x-auto">
            <div class="p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Delivery Progress</h2>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Order ID</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Tracking</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Last Updated</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-400">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($orders as $order)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->tracking_number ?? '-' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->status }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">{{ $order->updated_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-white">
                                {{-- Simple progress bar based on status --}}
                                @php
                                    $progress = 0;
                                    if ($order->status === 'Pending') $progress = 20;
                                    elseif ($order->status === 'Processing') $progress = 40;
                                    elseif ($order->status === 'Shipped') $progress = 70;
                                    elseif ($order->status === 'Delivered') $progress = 100;
                                @endphp
                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-primary-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-1">{{ $progress }}%</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>