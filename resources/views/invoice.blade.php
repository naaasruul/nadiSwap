<x-layouts.customer-layout>
	<section class="bg-gray-50 dark:bg-gray-900 py-12">
		<div class="max-w-5xl mx-auto px-6">
			<!-- Added Back to Account button at top with arrow -->
			<div class="mb-4">
				<a href="{{ route('my-account') }}"
					class="hover:underline focus:ring-0 focus:outline-none inline-flex items-center bg-primary-700 hover:bg-primary-800 text-white font-medium rounded-lg text-sm py-2 dark:bg-primary-600 dark:hover:bg-primary-700">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-4"
						viewBox="0 0 16 16">
						<path fill-rule="evenodd"
							d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
					</svg>
					Back to Account
				</a>
			</div>

			<div class="mb-8">
				<h1 class="text-3xl font-bold text-gray-900 dark:text-white">Invoice</h1>
				<p class="text-sm text-gray-500 dark:text-gray-400">Order Summary & Payment Details</p>
			</div>

			<div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
					<div>
						<h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Order Details</h2>
						<ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
							<li><span class="font-semibold">Order ID:</span> {{ $order->id }}</li>
							<li><span class="font-semibold">Date:</span> {{ $order->created_at->format('M d, Y') }}</li>
							<li><span class="font-semibold">Payment Status:</span>
								<span
									class="px-2.5 py-0.5 text-xs font-medium mx-1 mt-1.5 inline-flex shrink-0 items-center rounded capitalize 
					{{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : ($order->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
									{{ $order->payment_status }}
								</span>
							</li>
							<li><span class="font-semibold">Delivery Status:</span>
								<span
									class="px-2.5 py-0.5 text-xs font-medium mx-1 mt-1.5 inline-flex shrink-0 items-center rounded capitalize 
					{{ $order->delivery_status == 'delivered' ? 'bg-green-100 text-green-800' : ($order->delivery_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
									{{ $order->delivery_status }}
								</span>
							</li>
						</ul>
					</div>

					<div>
						<h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Billing Info</h2>
						<ul class="text-sm text-gray-700 dark:text-gray-300 space-y-2">
							<li><span class="font-semibold">Buyer:</span> {{ $order->buyer->name ?? 'Guest' }}</li>
							<li><span class="font-semibold">Seller:</span> {{ $order->seller->name ?? 'Seller' }}</li>
							<li><span class="font-semibold">Payment:</span> {{ ($order->payment_method ==
								'online_banking' ? 'Online Banking' : 'Cash On Delivery') }}</li>
							<li><span class="font-semibold">Shipping Fee:</span> RM{{ number_format($shipping_total, 2)}}</li>
							<li><span class="font-semibold">Total:</span> RM{{ number_format($order->total, 2) }}</li>
						</ul>
					</div>
				</div>

				<h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Purchased Items</h3>
				<div class="overflow-x-auto">
					<table class="min-w-full text-sm text-left border-collapse">
						<thead>
							<tr class="border-b border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300">
								<th class="py-3 px-4 font-semibold">Product</th>
								<th class="py-3 px-4 font-semibold">Quantity</th>
								<th class="py-3 px-4 font-semibold">Unit Price</th>
								<th class="py-3 px-4 font-semibold">Subtotal</th>
							</tr>
						</thead>
						<tbody>
							@foreach($decodedOrder as $item)
							<tr class="border-b border-gray-200 dark:border-gray-700">
								<td class="py-3 px-4">{{ $item['name'] ?? 'Item' }}</td>
								<td class="py-3 px-4">{{ $item['quantity'] }}</td>
								<td class="py-3 px-4">RM{{ number_format($item['price'], 2) }}</td>
								<td class="py-3 px-4">RM{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="mt-6 text-right">
					<p class="text-lg font-bold text-gray-900 dark:text-white">
						Total: RM{{ number_format($order->total, 2) }}
					</p>
				</div>
			</div>
		</div>
	</section>
</x-layouts.customer-layout>