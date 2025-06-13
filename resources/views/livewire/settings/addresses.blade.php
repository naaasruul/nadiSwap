<div class="w-full">
	@include('partials.customer-header')

	<x-settings.layout :heading="__('Addresses')"
		:subheading="__('View your delivery addresses')">

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

	</x-settings.layout>
</div>