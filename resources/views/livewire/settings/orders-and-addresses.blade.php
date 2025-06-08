<div class="w-full">
    @include('partials.customer-header')

    <x-settings.layout :heading="__('Orders and Addresses')" :subheading="__('View your orders and delivery addresses')">

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
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

    <!-- Delivery Addresses -->
            <div class="mt-8" id="delivery-addresses">
				<h3 class="text-lg font-semibold mb-4">Delivery Addresses</h3>
				<div class="flex space-x-2">
					<button type="button" id="dropdownHelperRadioButton" data-dropdown-toggle="dropdownHelperRadio"
						class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-pink-700 rounded-lg hover:bg-pink-800">
						<span>My Addresses</span>
						<svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
							fill="none" viewBox="0 0 10 6">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="m1 1 4 4 4-4" />
						</svg>
					</button>
					<button type="button" data-modal-target="addAddressModal" data-modal-toggle="addAddressModal"
						class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-pink-700 rounded-lg hover:bg-pink-800">
						<i class="fa-solid fa-plus me-2"></i>
						<span>Add Address</span>
					</button>
				</div>

				<!-- Dropdown menu -->
				<div id="dropdownHelperRadio"
					class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-60 dark:bg-gray-700 dark:divide-gray-600">
					<ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
						aria-labelledby="dropdownHelperRadioButton">
						@if ($deliveryAddresses->isEmpty())
						<li>
							<div class="flex p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
								<div class="ms-2 text-sm">
									<label for="helper-radio-4" class="font-medium text-gray-900 dark:text-gray-300">
										<p id="helper-radio-text-4"
											class="text-xs font-normal text-gray-500 dark:text-gray-300">
											No delivery addresses found</p>
									</label>
								</div>
							</div>
						</li>
						@else
						@foreach ($deliveryAddresses as $address)
						<li class="flex items-center justify-between p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
							<div class="flex items-center">
								<input id="address-{{ $address->id }}" name="delivery_address" type="radio" value="{{ $address->id }}"
									class="w-4 h-4 text-pink-600 bg-gray-100 border-gray-300 focus:ring-pink-500 dark:focus:ring-pink-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
								<div class="ms-2 text-sm">
									<label for="address-{{ $address->id }}" class="font-medium text-gray-900 dark:text-gray-300">
										<div>{{ $address->address_line_1 }}</div>
										<p class="text-xs font-normal text-gray-500 dark:text-gray-300">
											{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
										</p>
									</label>
								</div>
							</div>
							<div class="flex gap-2">
								<!-- Edit Button -->
								<button type="button" class="text-blue-600 hover:underline text-xs"
									data-modal-target="editAddressModal-{{ $address->id }}"
									data-modal-toggle="editAddressModal-{{ $address->id }}">
									Edit
								</button>
								<!-- Delete Button -->
								<form action="{{ route('buyer.address.destroy', $address->id) }}" method="POST"
									onsubmit="return confirm('Are you sure you want to delete this address?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="text-red-600 hover:underline text-xs">Delete</button>
								</form>
							</div>
						</li>
						@endforeach
						@endif
					</ul>
				</div>
			</div>

            <!-- Latest Orders -->
            <div class="mt-8 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold">Latest Orders</h3>
                {{-- Loop Order here --}}
                @if ($latestOrders->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
                @else
                    @foreach ($latestOrders as $order)
                    <x-order-list :orderId="$order->id" :date="$order->created_at->format('d/m/Y')" :price="$order->total" :payment_method="$order->payment_method" :delivery_address="$order->delivery_address" :status="$order->status" :productName="$order->product_name" :productImage="$order->product_image" :quantity="$order->quantity"
                        :delivery_status="$order->delivery_status" :payment_status="$order->payment_status" :order_status="$order->order_status" :actions="[
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
                    <x-cancelled-order-list :orderId="$cancelledOrder->order_id" :date="$cancelledOrder->created_at->format('d/m/Y')" :cancelledByRole="$cancelledOrder->cancelled_by_role" :cancellationReason="$cancelledOrder->cancellation_reason" :customCancellationReason="$cancelledOrder->custom_cancellation_reason" :additionalComments="$cancelledOrder->additional_comments" :actions="[
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
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
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
            <!-- Render all edit address modals OUTSIDE the dropdown container -->
			@if (!$deliveryAddresses->isEmpty())
				@foreach ($deliveryAddresses as $address)
					@include('buyer._edit-address-modal', ['address' => $address])
				@endforeach
			@endif

			<!-- Add Address Modal -->
			@include('buyer.add-address-modal')

    <!-- Latest Orders -->
    <div class="mt-8 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
        <h3 class="mb-4 text-lg font-semibold">Latest Orders</h3>
        @if ($latestOrders->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
        @else
            @foreach ($latestOrders as $order)
                <x-order-list 
                    :orderId="$order->id" 
                    :date="$order->created_at->format('d/m/Y')" 
                    :price="$order->total" 
                    :payment_method="$order->payment_method" 
                    :delivery_address="$order->delivery_address" 
                    :status="$order->status" 
                    :productName="$order->product_name" 
                    :productImage="$order->product_image" 
                    :quantity="$order->quantity"
                    :delivery_status="$order->delivery_status" 
                    :payment_status="$order->payment_status" 
                    :order_status="$order->order_status" 
                    :actions="[
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
        @if ($latestCancelledOrders->isEmpty())
            <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
        @else
            @foreach ($latestCancelledOrders as $cancelledOrder)
                <x-cancelled-order-list 
                    :orderId="$cancelledOrder->order_id" 
                    :date="$cancelledOrder->created_at->format('d/m/Y')" 
                    :cancelledByRole="$cancelledOrder->cancelled_by_role" 
                    :cancellationReason="$cancelledOrder->cancellation_reason" 
                    :customCancellationReason="$cancelledOrder->custom_cancellation_reason" 
                    :additionalComments="$cancelledOrder->additional_comments" 
                    :actions="[
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

    <!-- Add Address Modal -->
    @if($showAddAddressModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeAddAddressModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800" wire:click.stop>
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Add New Address</h3>
                    <form wire:submit="saveAddress" class="space-y-4">
                        <div>
                            <flux:input wire:model="addressForm.address_line_1" label="Address Line 1" type="text" required />
                        </div>
                        <div>
                            <flux:input wire:model="addressForm.address_line_2" label="Address Line 2" type="text" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <flux:input wire:model="addressForm.city" label="City" type="text" required />
                            <flux:input wire:model="addressForm.state" label="State" type="text" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <flux:input wire:model="addressForm.postal_code" label="Postal Code" type="text" required />
                            <flux:input wire:model="addressForm.country" label="Country" type="text" required />
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="addressForm.is_default" id="is_default" class="rounded">
                            <label for="is_default" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Set as default address</label>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <flux:button type="button" variant="ghost" wire:click="closeAddAddressModal">Cancel</flux:button>
                            <flux:button type="submit" variant="primary">Save Address</flux:button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Edit Address Modal -->
    @if($editingAddress)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeEditAddressModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800" wire:click.stop>
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Edit Address</h3>
                    <form wire:submit="updateAddress" class="space-y-4">
                        <div>
                            <flux:input wire:model="addressForm.address_line_1" label="Address Line 1" type="text" required />
                        </div>
                        <div>
                            <flux:input wire:model="addressForm.address_line_2" label="Address Line 2" type="text" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <flux:input wire:model="addressForm.city" label="City" type="text" required />
                            <flux:input wire:model="addressForm.state" label="State" type="text" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <flux:input wire:model="addressForm.postal_code" label="Postal Code" type="text" required />
                            <flux:input wire:model="addressForm.country" label="Country" type="text" required />
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model="addressForm.is_default" id="edit_is_default" class="rounded">
                            <label for="edit_is_default" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Set as default address</label>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <flux:button type="button" variant="ghost" wire:click="closeEditAddressModal">Cancel</flux:button>
                            <flux:button type="submit" variant="primary">Update Address</flux:button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
    </x-settings.layout>
</div>