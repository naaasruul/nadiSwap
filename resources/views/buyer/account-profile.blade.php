<x-layouts.customer-layout>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-8">
        <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">

            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl md:mb-6">My Account</h2>

            <div class="grid grid-cols-2 gap-6 border-b border-t border-gray-200 py-4 dark:border-gray-700 md:py-8 lg:grid-cols-2 xl:gap-16">
                <x-order-card icon="fa-regular fa-chart-bar" title="Orders made" :count="$ordersCount" />
                <x-order-card icon="fa-regular fa-star" title="Reviews added" :count="$reviewsCount" />
            </div>

            <div class="py-4 md:py-8">
                <div class="mb-4 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
                    <div class="space-y-4">
                        <div class="flex space-x-4">
                            {{-- USER PROFILE PICTURE --}}
                            <img class="h-16 w-16 rounded-lg"
                                src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/helene-engels.png"
                                alt="Helene avatar" />
                            {{-- USER NAME --}}
                            <div>
                                <h2
                                    class="flex items-center text-xl font-bold leading-none text-gray-900 dark:text-white sm:text-2xl">
                                    {{ $user->name }}</h2>
                            </div>
                        </div>
                        {{-- EMAIL ADDRESS --}}
                        <dl class="">
                            <dt class="font-semibold text-gray-900 dark:text-white">Email Address</dt>
                            <dd class="text-gray-500 dark:text-gray-400">{{ $user->email }}</dd>
                        </dl>
                        {{-- ADDRESSES --}}
                        <dl>
                            <dt class="font-semibold text-gray-900 dark:text-white">Phone Number</dt>
                            <dd class="text-gray-500 dark:text-gray-400">{{ $user->phone_number }}</dd>
                        </dl>
                        <button type="button" data-modal-target="accountInformationModal2"
                            data-modal-toggle="accountInformationModal2"
                            class="inline-flex w-full items-center justify-center rounded-lg bg-pink-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-pink-800 focus:outline-none focus:ring-4 focus:ring-pink-300 dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800 sm:w-auto">
                            <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z">
                                </path>
                            </svg>
                            Edit your data
                        </button>
                    </div>
                    <div class="space-y-4">
                        <dl>
                            <dt class="font-semibold text-gray-900 dark:text-white">Delivery Address</dt>
                            <button id="dropdownHelperRadioButton" data-dropdown-toggle="dropdownHelperRadio"
                                class="text-white mt-2 bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800"
                                type="button">My Addresses <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <button
                                data-modal-target="addAddressModal" data-modal-toggle="addAddressModal"
                                class="text-white mt-2 bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center  items-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <!-- Dropdown menu -->
                            <div id="dropdownHelperRadio"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-60 dark:bg-gray-700 dark:divide-gray-600"
                                data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top"
                                style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 6119.5px, 0px);">
                                <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownHelperRadioButton">
                                    @if ($deliveryAddresses->isEmpty())
                                    <li>
                                        <div class="flex p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <div class="ms-2 text-sm">
                                                <label for="helper-radio-4"
                                                    class="font-medium text-gray-900 dark:text-gray-300">
                                                    <p id="helper-radio-text-4"
                                                        class="text-xs font-normal text-gray-500 dark:text-gray-300">
                                                        No delivery addresses found</p>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    @else
                                    @foreach ($deliveryAddresses as $address)
                                    <li>
                                        <div class="flex p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <div class="flex items-center h-5">
                                                <input id="address-{{ $address->id }}" name="delivery_address"
                                                    type="radio" value="{{ $address->id }}"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            </div>
                                            <div class="ms-2 text-sm">
                                                <label for="helper-radio-4"
                                                    class="font-medium text-gray-900 dark:text-gray-300">
                                                    <div>{{ $address->address_line_1 }}</div>
                                                    <p id="helper-radio-text-4"
                                                        class="text-xs font-normal text-gray-500 dark:text-gray-300">
                                                        {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                                </label>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                    @endif

                                </ul>
                            </div>
                        </dl>

                    </div>
                </div>

            </div>
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800 md:p-8">
                <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Latest orders</h3>
                {{-- Loop Order here --}}
                @if ($latestOrders->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">No orders found.</p>
                @else
                @foreach ($latestOrders as $order)
                <x-order-list :orderId="$order->id" :date="$order->created_at->format('d.m.Y')" :price="$order->total"
                    :status="$order->status" :actions="[
                     ['url' => '#', 'label' => 'Order again', 'icon' => '<svg class=\'me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' fill=\'none\' viewBox=\'0 0 24 24\'><path stroke=\'currentColor\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4\'></path></svg>'],
                     ['url' => '#', 'label' => 'Order details', 'icon' => '<svg class=\'me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' fill=\'none\' viewBox=\'0 0 24 24\'><path stroke=\'currentColor\' stroke-width=\'2\' d=\'M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z\'></path><path stroke=\'currentColor\' stroke-width=\'2\' d=\'M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z\'></path></svg>'],
                     ['url' => '#', 'label' => 'Cancel order', 'icon' => '<svg class=\'me-1.5 h-4 w-4\' aria-hidden=\'true\' xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' fill=\'none\' viewBox=\'0 0 24 24\'><path stroke=\'currentColor\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z\'></path></svg>', 'class' => 'text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white']
                        ]" />
                @endforeach

                @endif

            </div>
        </div>
        @include('buyer.edit-profile-modal')

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
                            class="font-medium text-pink-700 hover:underline dark:text-pink-500">@heleneeng</a>, are you
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

        @include('buyer.edit-address-modal')

    </section>
</x-layouts.customer-layout>