@props(['icon', 'title', 'count', 'percentage' => null])

<div>
    <i class="{{ $icon }} fa-xl h-8 w-8 text-pink-400 dark:text-gray-500"></i>
    <h3 class="mb-2 text-gray-500 dark:text-gray-400">{{ $title }}</h3>
    <span class="flex items-center text-2xl font-bold text-gray-900 dark:text-white">
        {{ $count }}
        @if ($percentage)
            <span
                class="ms-2 inline-flex items-center rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300">
                <svg class="-ms-1 me-1 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="M12 6v13m0-13 4 4m-4-4-4 4"></path>
                </svg>
                {{ $percentage }}
            </span>
        @endif
    </span>
</div>