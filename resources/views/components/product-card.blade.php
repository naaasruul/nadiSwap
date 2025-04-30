<div class="product-card group relative overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all hover:shadow-lg hover:cursor-pointer dark:border-gray-700 dark:bg-gray-800">
    <div class="relative h-56 w-full overflow-hidden bg-gray-100 dark:bg-gray-700">
        <a href="{{ route('products.show', $product->id) }}">
            <img class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-105 dark:hidden"
                src="{{ asset(json_decode($product->images)[0]) }}" alt="{{ $product->name }}" />
            <img class="absolute inset-0 hidden h-full w-full object-cover transition-transform duration-300 group-hover:scale-105 dark:block"
                src="{{ asset(json_decode($product->images)[0]) }}" alt="{{ $product->name }}" />
        </a>
        <!-- Quick Add Button -->
        <div class="quick-add-button absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 backdrop-blur-[2px] transition-opacity duration-300 group-hover:opacity-100">
            <form action="{{ route('cart.add') }}" method="POST" class="inline-block">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1" min="1">
                <button type="submit" 
                    class="add-to-cart-btn rounded-lg bg-white/90 px-4 py-2 font-medium text-gray-900 shadow-sm transition-all duration-200 hover:bg-gray-900 hover:text-white hover:cursor-pointer dark:bg-gray-800/90 dark:text-white dark:hover:bg-gray-900 group-hover:scale-105">
                    <span class="flex items-center">
                        <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span class="loading-text">Add to Cart</span>
                    </span>
                </button>
            </form>
        </div>

        <!-- Recommendation Badge -->
        @if(isset($product->relevance_score) && $product->relevance_score > 0 && !($product->is_direct_match ?? false))
            <span class="absolute right-2 top-2 rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                Recommended
            </span>
        @endif
    </div>

    <div class="p-5">
        <!-- Category Badge -->
        @if($product->category)
            <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">
                {{ $product->category->name }}
            </span>
        @endif

        <!-- Rating -->
        <div class="mb-2 mt-2 flex items-center">
            <div class="flex items-center">
                @for ($i = 1; $i <= 5; $i++) 
                    <svg class="h-4 w-4 {{ $i <= number_format($product->reviews->avg('rating'), 1) ? 'text-yellow-300' : 'text-gray-300 dark:text-gray-600' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                        <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                    </svg>
                @endfor
                <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ number_format($product->reviews->avg('rating'), 1) }} ({{ $product->reviews->count() }})
                </span>
            </div>
        </div>

        <!-- Product Name -->
        <a href="{{ route('products.show', $product->id) }}" class="product-name mb-3 block text-lg font-semibold leading-tight text-gray-900 hover:underline dark:text-white">
            {{ $product->name }}
        </a>

        <!-- Price and Add Button -->
        <div class="mt-4 flex items-center justify-between">
            <span class="text-2xl font-bold text-gray-900 dark:text-white">RM{{ $product->price }}</span>
        </div>
    </div>
</div>
