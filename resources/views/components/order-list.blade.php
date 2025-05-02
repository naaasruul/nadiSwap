@props(['orderId', 'date', 'price', 'delivery_status', 'payment_status', 'payment_method', 'actions' => []])

<div class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 pb-4 dark:border-gray-700 md:pb-5">
    <dl class="w-1/2 sm:w-48">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Order ID:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
            <a href="{{ route('invoice.show', $orderId) }}" class="hover:underline">{{ $orderId }}</a>
        </dd>
    </dl>

    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Date:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $date }}</dd>
    </dl>

    <dl class="w-1/2 sm:w-1/5 md:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Price:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ (number_format($price, 2)) }}</dd>
    </dl>

    <dl class="w-1/2 sm:w-1/5 md:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Payment Method:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ ($payment_method == 'online_banking' ? 'Online Banking' : 'QR Payment') }}</dd>
    </dl>

    <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Delivery Status:</dt>
        <dd class="me-2 mt-1.5 inline-flex shrink-0 items-center rounded capitalize
        {{ $delivery_status == 'delivered' ? 'bg-green-100 text-green-800' : ($delivery_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}
         px-2.5 py-0.5 text-xs font-medium">
            <svg class="me-1 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z">
                </path>
            </svg>
            {{ $delivery_status }}
        </dd>
    </dl>

    <dl class="w-1/2 sm:w-1/4 sm:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Payment Status:</dt>
        <dd class="me-2 mt-1.5 inline-flex shrink-0 items-center rounded  capitalize
        {{ $payment_status == 'completed' ? 'bg-green-100 text-green-800' : ($payment_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}
         px-2.5 py-0.5 text-xs font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="me-1 h-3 w-3"
                viewBox="0 0 16 16">
                <path
                    d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a2 2 0 0 1-1-.268M1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1" />
            </svg>
            {{ $payment_status }}
        </dd>
    </dl>

    {{-- <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end sm:gap-4">
        <button id="actionsMenuDropdownModal{{ $orderId }}" data-dropdown-toggle="dropdownOrderModal{{ $orderId }}"
            type="button"
            class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-pink-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 md:w-auto">
            Actions
            <svg class="-me-0.5 ms-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 9-7 7-7-7"></path>
            </svg>
        </button>
        <div id="dropdownOrderModal{{ $orderId }}"
            class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
            data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="bottom">
            <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
                aria-labelledby="actionsMenuDropdown{{ $orderId }}">
                @foreach ($actions as $action)
                <li>
                    <a href="{{ $action['url'] ?? '#' }}"
                        class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm {{ $action['class'] ?? 'text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white' }}">
                        {!! $action['icon'] !!}
                        <span>{{ $action['label'] }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div> --}}
</div>