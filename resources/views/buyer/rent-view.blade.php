<x-layouts.customer-layout>
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-10 mx-auto max-w-screen-xl px-4 2xl:px-0">
        <x-dashboard-header>MPPFind4U 🏠</x-dashboard-header>

        {{-- Mini section: Promote Find Housemate --}}
        <div class="mb-8 flex flex-col sm:flex-row items-center justify-between bg-orange-50 dark:bg-orange-900 border border-orange-200 dark:border-orange-700 rounded-lg px-6 py-4">
            <div class="mb-2 sm:mb-0">
                <span class="text-orange-700 dark:text-orange-200 font-semibold text-lg flex items-center gap-2">
                    <i class="fa-solid fa-user-group"></i>
                    Have a house but looking for a housemate?
                </span>
                <p class="text-orange-600 dark:text-orange-300 text-sm mt-1">Post your house and find the perfect housemate easily!</p>
            </div>
            <a href="{{ route('rent.view') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-orange-400">
                <i class="fa-solid fa-plus"></i>
                Find Housemate
            </a>
        </div>

        @if($products->count())
            <div class="products-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    @include('components.rent.rent-card', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 21m5.25-4l.75 4m-7.5-4h10.5a2.25 2.25 0 002.25-2.25V7.5A2.25 2.25 0 0017.25 5.25H6.75A2.25 2.25 0 004.5 7.5v7.25A2.25 2.25 0 006.75 17z" />
                </svg>
                <p class="text-gray-500 text-lg mb-2">No rental listings found.</p>
                <p class="text-gray-400">Try adjusting your filters or check back later.</p>
            </div>
        @endif
    </section>
</x-layouts.customer-layout>
