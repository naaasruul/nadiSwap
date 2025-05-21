@props(['rating', 'username', 'createdAt', 'content','title','userId','reviewId'])

{{-- Review Card Component --}}

<div class="gap-3 pb-6 sm:flex sm:items-start my-6">
    <div class="shrink-0 space-y-2 sm:w-48 md:w-72">
        <div class="flex items-center gap-0.5">
            @for ($i = 1; $i <= 5; $i++)
                <svg class="h-4 w-4 {{ $i <= $rating ? 'text-yellow-300' : 'text-gray-300 dark:text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                </svg>
            @endfor
        </div>

        <div class="space-y-0.5">
            <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $username }}</p>
            <p class="text-sm font-normal text-gray-500 dark:text-gray-400">{{ $createdAt }}</p>
            @if (auth()->check() && auth()->id() === $userId)
                <form action="{{ route('reviews.destroy', $reviewId) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline text-sm">Remove</button>
                </form>
                @endif
        </div>
    </div>

    <div class="mt-4 min-w-0 flex-1 space-y-4 sm:mt-0">
        <p class="text-base font-normal text-gray-900 dark:text-gray-400">{{ $title }}</p>
        <p class="text-base font-normal text-gray-500 dark:text-gray-400">{{ $content }}</p>
    </div>
</div>