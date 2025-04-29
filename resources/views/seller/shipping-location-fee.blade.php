<x-layouts.app :title="__('Shipping Location Fees')">
	<x-dashboard-header>Shipping Location and Fees</x-dashboard-header>

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

	<!-- Add Location Modal Toggle -->
	<div class="w-full flex justify-end mb-4">
		<button data-modal-target="create-location" data-modal-toggle="create-location"
			class="block text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800"
			type="button">
			Add Location
		</button>
	</div>

	<div class="relative overflow-x-auto">
		<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
			<thead class="text-xs">
				<tr>
					<th scope="col" class="px-6 py-3">Location</th>
					<th scope="col" class="px-6 py-3">Shipping Fee</th>
					<th scope="col" class="px-6 py-3">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($fees as $fee)
				<tr
					class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
					<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						{{ $fee->location_name }}
					</td>
					<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						{{ $fee->price }}
					</td>
					<td class="px-6 py-4">
						<!-- Edit Button -->
						<button data-modal-target="edit-location-{{ $fee->id }}"
							data-modal-toggle="edit-location-{{ $fee->id }}"
							class="text-blue-600 hover:underline dark:text-blue-500">Edit</button>
					</td>
					<td>
						<!-- Delete Button -->
						<button data-modal-target="delete-location-{{ $fee->id }}"
							data-modal-toggle="delete-location-{{ $fee->id }}"
							class="text-red-600 hover:underline dark:text-red-500">Delete</button>

					</td>
				</tr>

				<!-- Edit Location Modal -->
				<div id="edit-location-{{ $fee->id }}" tabindex="-1" aria-hidden="true"
					class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
					<div class="relative w-full max-w-md max-h-full">
						<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
							<div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
								<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
									Edit Location
								</h3>
								<button type="button"
									class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
									data-modal-toggle="edit-location-{{ $fee->id }}">
									<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
										xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd"
											d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
											clip-rule="evenodd"></path>
									</svg>
								</button>
							</div>
							<div class="p-6">
								<form action="{{ route('seller.shipping-fee.update', $fee->id) }}" method="POST">
									@csrf
									@method('PUT')
									<div class="mb-4">
										<label for="location_name"
											class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Location
											Name</label>
										<input type="text" id="location_name" name="location_name"
											value="{{ $fee->location_name }}"
											class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
											required>
									</div>
									<div class="mb-4">

										<label for="price"
											class="block text-sm font-medium text-gray-900 dark:text-white mb-2">Shipping Price (RM)</label>
										<input type="text" id="price" name="price" value="{{ $fee->price }}"
											class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
											required>
									</div>
									<button type="submit"
										class="w-full text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
										Save Changes
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>

				<!-- Delete Location Modal -->
				<div id="delete-location-{{ $fee->id }}" tabindex="-1" aria-hidden="true"
					class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
					<div class="relative w-full max-w-md max-h-full">
						<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
							<div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
								<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
									Delete Location
								</h3>
								<button type="button"
									class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
									data-modal-toggle="delete-location-{{ $fee->id }}">
									<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
										xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd"
											d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
											clip-rule="evenodd"></path>
									</svg>
								</button>
							</div>
							<div class="p-6 space-y-6">
								<p class="text-sm text-gray-500 dark:text-gray-400">
									Are you sure you want to delete this location and its fee? This action cannot be
									undone.
								</p>
								<form action="{{ route('seller.shipping-fee.destroy', $fee->id) }}" method="POST">
									@csrf
									@method('DELETE')
									<button type="submit"
										class="w-full text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-800">
										Delete
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</tbody>
		</table>
	</div>

	@include('Modal.add-location')
</x-layouts.app>