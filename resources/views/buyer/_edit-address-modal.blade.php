<!-- Edit Address Modal -->
<div id="editAddressModal-{{ $address->id }}" tabindex="-1" aria-hidden="true"
    class="fixed left-0 right-0 top-0 z-50 hidden h-modal w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 md:h-full">
    <div class="relative h-full w-full max-w-md p-4 md:h-auto">
        <div class="relative rounded-lg bg-white p-4 shadow dark:bg-gray-800 sm:p-5">
            <form action="{{ route('buyer.address.update', $address->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="address_line_1_{{ $address->id }}" class="block text-sm font-medium text-gray-900 dark:text-white">Address Line 1</label>
                    <input type="text" name="address_line_1" id="address_line_1_{{ $address->id }}" value="{{ $address->address_line_1 }}" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500">
                </div>
                <div class="mb-4">
                    <label for="address_line_2_{{ $address->id }}" class="block text-sm font-medium text-gray-900 dark:text-white">Address Line 2</label>
                    <input type="text" name="address_line_2" id="address_line_2_{{ $address->id }}" value="{{ $address->address_line_2 }}"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500">
                </div>
                <div class="mb-4">
                    <label for="city_{{ $address->id }}" class="block text-sm font-medium text-gray-900 dark:text-white">City</label>
                    <input type="text" name="city" id="city_{{ $address->id }}" value="{{ $address->city }}" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500">
                </div>
                <div class="mb-4">
                    <label for="state_{{ $address->id }}" class="block text-sm font-medium text-gray-900 dark:text-white">State</label>
                    <input type="text" name="state" id="state_{{ $address->id }}" value="{{ $address->state }}" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500">
                </div>
                <div class="mb-4">
                    <label for="postal_code_{{ $address->id }}" class="block text-sm font-medium text-gray-900 dark:text-white">Postal Code</label>
                    <input type="text" name="postal_code" id="postal_code_{{ $address->id }}" value="{{ $address->postal_code }}" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500">
                </div>
                <div class="mb-4">
                    <label for="country_{{ $address->id }}" class="block text-sm font-medium text-gray-900 dark:text-white">Country</label>
                    <input type="text" name="country" id="country_{{ $address->id }}" value="{{ $address->country }}" required
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500">
                </div>
                <div class="flex items-center justify-end space-x-4">
                    <button type="button" data-modal-toggle="editAddressModal-{{ $address->id }}"
                        class="rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-orange-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-600">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-orange-700 px-3 py-2 text-sm font-medium text-white hover:bg-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>