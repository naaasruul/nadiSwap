@props(['orderId', 'cancelledByRole', 'cancellationReason', 'additionalComments', 'customCancellationReason', 'date', 'actions' => []])

<div class="flex flex-wrap items-center gap-y-4 border-b border-gray-200 pb-4 dark:border-gray-700 md:pb-5">
    <dl class="w-1/2 sm:w-48">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Order ID:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">
            <a href="{{ route('invoice.show', $orderId) }}" class="hover:underline">{{ $orderId }}</a>
        </dd>
    </dl>
    @php
        $buyerClasses = match ($cancelledByRole) {
            'buyer' => 'bg-yellow-100 text-yellow-800',
            'seller' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    @endphp

    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Cancelled By:</dt>
        <dd class="me-2 mt-1.5 inline-flex shrink-0 items-center rounded capitalize {{ $buyerClasses }} px-2.5 py-0.5 text-xs font-medium">
            <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
            </svg>
            {{ ucfirst($cancelledByRole) }}
        </dd>
    </dl>

    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Date:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $date }}</dd>
    </dl>

    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Reason:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ ucfirst($cancellationReason) }}{{ isset($customCancellationReason) ? ', ' . $customCancellationReason : '' }}</dd>
    </dl>

    <dl class="w-1/2 sm:w-1/4 md:flex-1 lg:w-auto">
        <dt class="text-base font-medium text-gray-500 dark:text-gray-400">Additional Comments:</dt>
        <dd class="mt-1.5 text-base font-semibold text-gray-900 dark:text-white">{{ $additionalComments ?? '--' }}</dd>
    </dl>

    <div class="w-full sm:flex sm:w-32 sm:items-center sm:justify-end sm:gap-4">
        @foreach ($actions as $action)
            <a href="{{ $action['url'] ?? '#' }}"
                class="flex w-full items-center justify-center rounded-md border border-gray-200 bg-white py-2 text-sm font-medium   {{ $action['class'] ?? 'hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white' }}">
                {!! $action['icon'] !!}
                <span>{{ $action['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>