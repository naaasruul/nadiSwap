@props(['ratings', 'averageRating'])

<div class="my-6 gap-8 sm:flex sm:items-start md:my-8">
    <!-- Overall Rating and Write a Review Button -->
    <div class="shrink-0 space-y-4">
        <p class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">
            {{ $averageRating }} out of 5
        </p>
        <button type="button" data-modal-target="review-modal" data-modal-toggle="review-modal"
            class="mb-2 me-2 rounded-lg bg-primary-700 px-5 py-2.5 text-sm font-medium text-accent-content dark:text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
            Write a review
        </button>
    </div>

    <!-- Ratings Breakdown -->
    <div class="mt-6 min-w-0 flex-1 space-y-3 sm:mt-0">
        @foreach ($ratings as $ratingData)
            <div class="flex items-center gap-2">
                <p class="w-2 shrink-0 text-start text-sm font-medium leading-none text-gray-900 dark:text-white">
                    {{ $ratingData['rating'] }}
                </p>
                <svg class="h-4 w-4 shrink-0 text-yellow-300" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                </svg>
                <div class="h-1.5 w-80 rounded-full bg-gray-200 dark:bg-gray-700">
                    <div class="h-1.5 rounded-full bg-yellow-300" style="width: {{ $ratingData['percentage'] }}%"></div>
                </div>
                <a href="#"
                    class="w-8 shrink-0 text-right text-sm font-medium leading-none text-primary-700 hover:underline dark:text-primary-500 sm:w-auto sm:text-left">
                    {{ $ratingData['reviewCount'] }}
                    <span class="hidden sm:inline">reviews</span>
                </a>
            </div>
        @endforeach
    </div>
</div>