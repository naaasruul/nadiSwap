<div class="w-full">
	@include('partials.customer-header')

	<x-settings.layout :heading="__('Orders and Addresses')"
		:subheading="__('View your orders and delivery addresses')">

		<!-- Success/Error Messages -->
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

		<!-- Stats Cards -->
		<div class="grid grid-cols-2 gap-6 border-b border-gray-200 py-4 dark:border-gray-700 md:py-8">
			<x-order-card icon="fa-regular fa-chart-bar" title="Orders made" :count="$ordersCount" />
			<x-order-card icon="fa-regular fa-star" title="Reviews added" :count="$reviewsCount" />
		</div>

		<!-- Render all edit address modals OUTSIDE the dropdown container -->
		@if (!$deliveryAddresses->isEmpty())
			@foreach ($deliveryAddresses as $address)
				@include('buyer._edit-address-modal', ['address' => $address])
			@endforeach
		@endif
		<!-- Add Address Modal -->
		@include('buyer.add-address-modal')

		<!-- Delivery Addresses -->
		<div class="mt-8" id="delivery-addresses">
			<div class="flex items-center justify-end mb-4">
				<button type="button" data-modal-target="addAddressModal" data-modal-toggle="addAddressModal"
					class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-pink-700 rounded-lg hover:bg-pink-800">
					<i class="fa-solid fa-plus me-2"></i>
					<span>Add Address</span>
				</button>
			</div>
		</div>

		<div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
			<h3 class="mb-4 text-lg font-semibold">Addresses</h3>
			@if ($deliveryAddresses->isEmpty())
				<p class="text-gray-500 dark:text-gray-400">No Delivery Address set.</p>
			@else
				<div class="relative overflow-x-auto">
					<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
							<tr>
								<th scope="col" class="px-6 py-3">Address</th>
								<th scope="col" class="px-6 py-3">City</th>
								<th scope="col" class="px-6 py-3">State</th>
								<th scope="col" class="px-6 py-3">Postal Code</th>
								<th scope="col" class="px-6 py-3">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($deliveryAddresses as $address)
								<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
									<td class="px-6 py-4">{{ $address->address_line_1 }}{{ $address->address_line_2 ? ', ' . $address->address_line_2 : '' }}</td>
									<td class="px-6 py-4">{{ $address->city }}</td>
									<td class="px-6 py-4">{{ $address->state }}</td>
									<td class="px-6 py-4">{{ $address->postal_code }}</td>
									<td class="px-6 py-4 space-x-2">
										<button type="button" class="text-blue-600 hover:underline"
											data-modal-target="editAddressModal-{{ $address->id }}"
											data-modal-toggle="editAddressModal-{{ $address->id }}">
											Edit
										</button>
										<form action="{{ route('buyer.address.destroy', $address->id) }}" method="POST"
											class="inline"
											onsubmit="return confirm('Are you sure you want to delete this address?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="text-red-600 hover:underline">Delete</button>
										</form>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@if($deliveryAddresses->hasPages())
					<div class="mt-8" id="pagination-section-addresses">
						{{ $deliveryAddresses->fragment('pagination-section-addresses')->links() }}
					</div>
				@endif
			@endif
		</div>


		<!-- Latest Orders -->
		<div class="mt-8 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
			<h3 class="mb-4 text-lg font-semibold">Latest Orders</h3>
			{{-- Loop Order here --}}
			@if ($latestOrders->isEmpty())
				<p class="text-gray-500 dark:text-gray-400">No orders found.</p>
			@else
				@foreach ($latestOrders as $order)
					<x-order-list :orderId="$order->id" :date="$order->created_at->format('d/m/Y')" :price="$order->total"
						:payment_method="$order->payment_method" :delivery_address="$order->delivery_address"
						:status="$order->status" :productName="$order->product_name" :productImage="$order->product_image"
						:quantity="$order->quantity" :delivery_status="$order->delivery_status"
						:payment_status="$order->payment_status" :order_status="$order->order_status" :actions="[
									['url' => route('buyer.orders.show-status', $order->id), 'label' => 'Order details', 'icon' => '<svg class=\'me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' fill=\'none\' viewBox=\'0 0 24 24\'><path stroke=\'currentColor\' stroke-width=\'2\' d=\'M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z\'></path><path stroke=\'currentColor\' stroke-width=\'2\' d=\'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z\'></path></svg>'],
									...$order->order_status === 'pending' ? [
										['url' => route('buyer.orders.request-cancel', $order->id), 'label' => 'Cancel order', 'icon' => '<svg class=\'me-1.5 h-4 w-4\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' fill=\'none\' viewBox=\'0 0 24 24\'><path stroke=\'currentColor\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z\'></path></svg>', 'class' => 'text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white']
									] : []
								]" />
				@endforeach
				@if($latestOrders->hasPages())
					<div class="mt-8" id="pagination-section">
						{{ $latestOrders->fragment('pagination-section')->links() }}
					</div>
				@endif
			@endif
		</div>

		<!-- Cancelled Orders -->
		<div class="mt-8 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
			<h3 class="mb-4 text-lg font-semibold">Cancelled Orders</h3>
			{{-- Loop Order here --}}
			@if ($latestCancelledOrders->isEmpty())
				<p class="text-gray-500 dark:text-gray-400">No orders found.</p>
			@else
				@foreach ($latestCancelledOrders as $cancelledOrder)
				<x-cancelled-order-list :orderId="$cancelledOrder->order_id"
					:date="$cancelledOrder->created_at->format('d/m/Y')"
					:cancelledByRole="$cancelledOrder->cancelled_by_role"
					:cancellationReason="$cancelledOrder->cancellation_reason"
					:customCancellationReason="$cancelledOrder->custom_cancellation_reason"
					:additionalComments="$cancelledOrder->additional_comments" :actions="[
								['url' => route('buyer.orders.show-status', $cancelledOrder->order_id), 'label' => 'Order details', 'icon' => '<svg class=\'me-1.5 h-4 w-4 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' fill=\'none\' viewBox=\'0 0 24 24\'><path stroke=\'currentColor\' stroke-width=\'2\' d=\'M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z\'></path><path stroke=\'currentColor\' stroke-width=\'2\' d=\'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z\'></path></svg>']
							]" />
				@endforeach
				@if($latestCancelledOrders->hasPages())
					<div class="mt-8" id="pagination-section">
						{{ $latestCancelledOrders->fragment('pagination-section')->links() }}
					</div>
				@endif
			@endif
		</div>

		<div id="deleteOrderModal" tabindex="-1" aria-hidden="true"
			class="fixed left-0 right-0 top-0 z-50 hidden h-modal w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 md:h-full">
			<div class="relative h-full w-full max-w-md p-4 md:h-auto">
				<!-- Modal content -->
				<div class="relative rounded-lg bg-white p-4 text-center shadow dark:bg-gray-800 sm:p-5">
					<button type="button"
						class="absolute right-2.5 top-2.5 ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
						data-modal-toggle="deleteOrderModal">
						<svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
							xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd"
								d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
								clip-rule="evenodd"></path>
						</svg>
						<span class="sr-only">Close modal</span>
					</button>
					<div
						class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 p-2 dark:bg-gray-700">
						<svg class="h-8 w-8 text-gray-500 dark:text-gray-400" aria-hidden="true"
							xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
						</svg>
						<span class="sr-only">Danger icon</span>
					</div>
					<p class="mb-3.5 text-gray-900 dark:text-white"><a href="#"
							class="font-medium text-pink-700 hover:underline dark:text-pink-500">@heleneeng</a>,
						are you
						sure you want to delete this order from your account?</p>
					<p class="mb-4 text-gray-500 dark:text-gray-300">This action cannot be undone.</p>
					<div class="flex items-center justify-center space-x-4">
						<button data-modal-toggle="deleteOrderModal" type="button"
							class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-pink-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-600">No,
							cancel</button>
						<button type="submit"
							class="rounded-lg bg-red-700 px-3 py-2 text-center text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Yes,
							delete</button>
					</div>
				</div>
			</div>
		</div>

	</x-settings.layout>
</div>