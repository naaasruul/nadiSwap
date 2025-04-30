<x-layouts.customer-layout>
    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">All Categories</h2>
            <div class="space-y-10">
                @foreach($categories as $category)
                    <div>
                        <h3 class="mb-2 text-xl font-semibold text-primary-700 dark:text-primary-400">{{ $category->name }}</h3>
                        @if($category->products->count())
                            <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                                @foreach($category->products as $product)
                                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                                        <a href="{{ route('products.show', $product->id) }}">
                                            <img class="mx-auto mb-2 h-32 w-full object-contain" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                            <div class="font-semibold text-gray-900 dark:text-white">{{ $product->name }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">RM{{ $product->price }}</div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-gray-500 dark:text-gray-400">No products in this category.</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.customer-layout>
