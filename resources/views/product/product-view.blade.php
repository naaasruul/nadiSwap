<x-layouts.customer-layout>
    <x-section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
    @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
        {{ session('success') }}
    </div>
    @endif
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
                <!-- Product Image Carousel -->
                <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
                    <div class="relative aspect-square">
                        <!-- Left and Right Arrow Buttons -->
                        <button id="prevBtn" class="cursor-pointer absolute top-1/2 left-2 transform -translate-y-1/2 z-10 bg-white/30 backdrop-blur-md text-white p-3 rounded-full shadow-md hover:bg-white/40 focus:outline-none">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                          </svg>
                        </button>
                        <button id="nextBtn" class="cursor-pointer absolute top-1/2 right-2 transform -translate-y-1/2 z-10 bg-white/30 backdrop-blur-md text-white p-3 rounded-full shadow-md hover:bg-white/40 focus:outline-none">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                          </svg>
                        </button>

                        <!-- Focused Main Image (for light and dark modes) -->
                        <img id="mainImage" class="w-full h-full object-contain object-center dark:hidden" src="{{ asset('storage/'.json_decode($product->images)[0]) }}" alt="{{ $product->name }}">
                        <img id="mainImageDark" class="w-full h-full object-contain object-center hidden dark:block" src="{{ asset('storage/'.json_decode($product->images)[0]) }}" alt="{{ $product->name }}">
                    </div>
                    <!-- Thumbnail Grid -->
                    <div id="thumbnailGrid" class="mt-4 flex space-x-2 overflow-x-auto whitespace-nowrap">
                        @foreach(json_decode($product->images) as $img)
                            <img class="thumb inline-block cursor-pointer w-20 h-20 object-contain border border-transparent hover:border-orange-500" src="{{ asset('storage/'.$img) }}" alt="Thumbnail">
                        @endforeach
                    </div>
                </div>

                <!-- Product Details -->
                <div class="mt-6 sm:mt-8 lg:mt-0">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
                        {{ $product->name }}
                    </h1>
                    <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
                        <p class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">
                            RM{{ $product->price }}
                        </p>
                        @hasrole('buyer')
                            <div class="flex items-center gap-2 mt-2 sm:mt-0">
                                <div class="flex items-center gap-1">
                                    @for ($i = 1; $i <= 5; $i++) <svg
                                        class="w-4 h-4 {{ $i <= $averageRating ? 'text-yellow-300' : 'text-gray-300 dark:text-gray-500' }}"
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z" />
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-sm font-medium leading-none text-gray-500 dark:text-gray-400">
                                    ({{ number_format($averageRating, 1)}})
                                </p>
                                <a href="#review-section"
                                    class="text-sm font-medium leading-none text-gray-900 underline hover:no-underline dark:text-white">
                                    {{ $product->reviews_count }} Reviews
                                </a>
                            </div>
                        @endrole           
                    </div>

                    <!-- Add to Cart Form -->
                    <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
                        <form action="{{ route('cart.add') }}" method="POST" class="flex items-center">
                            @csrf
                            @role('buyer')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <!-- Added max attribute to restrict quantity -->
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                                class="bg-gray-50 border border-orange-500 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-15 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">

                            <button type="submit" 
                                class="ml-4 text-accent-content dark:text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center">
                                <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                </svg>
                                Add to cart
                            </button>
                            @elserole('seller')
                            <input type="hidden" name="product_id" value="{{ $product->id }} " disabled>
                            <!-- Optionally, you can add max attribute even for disabled input -->
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" disabled
                                class="bg-gray-50 border cursor-not-allowed border-orange-500 text-gray-900 text-sm rounded-lg focus:ring-orange-600 focus:border-orange-600 block w-15 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500">

                            <button type="button" disabled
                                class="ml-4 text-accent-content cursor-not-allowed dark:text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800 flex items-center justify-center">
                                <svg class="w-5 h-5 -ms-2 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                </svg>
                                Add to cart
                            </button>
                            @endrole
                        </form>
                    </div>
                    <!-- Quantity Limit Warning -->
                    <p id="quantityMessage" class="text-red-500 text-sm mt-2 hidden"></p>

                    <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />
                    <p class='text-gray-500 dark:text-gray-400 italic whitespace-nowrap flex'>
                        <svg class="w-6 h-6 text-gray-500 dark:text-gray-400 italic " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        {{ $product->seller->name }}
                    </p>
                    <p class="my-6 text-gray-500 dark:text-gray-400">
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
    </x-section>

    {{-- review section  --}}
    @hasrole('buyer')
    <x-section  class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div id='review-section' class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Reviews</h2>
            <x-review-progress-bar :product-id="$product->id" :canReview="$canReview"/>


            <div class="mt-6 divide-y divide-gray-200 dark:divide-gray-700">
                @if ($product->reviews->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">No reviews yet. Be the first to review this product!</p>
                @else
                    @foreach ($product->reviews as $review)
                    <x-review-card 
                            :rating="$review->rating" 
                            :username="$review->user->name"
                            :createdAt="$review->created_at->format('F j, Y \a\t H:i')" 
                            :content="$review->content" 
                            :title="$review->title" 
                            :userId="$review->user_id"
                            :reviewId="$review->id"
                            />
                    @endforeach
                @endif

            </div>
        </div>
    </x-section>
    @endrole


    <!-- Add review modal -->
    @include('components.review-modal')
    
    @push('scripts')
    <script src='{{ asset('js/add-review.js') }}'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function(){
        var images = @json(json_decode($product->images));
        var currentIndex = 0;
        
        // Initialize first thumbnail as active
        $('#thumbnailGrid img.thumb').removeClass('active');
        $('#thumbnailGrid img.thumb').eq(0).addClass('active');
        
        // Function to scroll the thumbnail container to the active thumbnail
        function scrollThumbnailIntoView(index) {
            var container = $('#thumbnailGrid');
            var thumbnail = container.find('img.thumb').eq(index);
            var containerWidth = container.width();
            var thumbWidth = thumbnail.outerWidth(true);
            // Calculate target scroll position: center the thumbnail within the container
            var targetScrollLeft = thumbnail.position().left + container.scrollLeft() - (containerWidth/2) + (thumbWidth/2);
            container.animate({ scrollLeft: targetScrollLeft }, 300);
        }
        
        // Thumbnail click: update main image and active class
        $('#thumbnailGrid img.thumb').on('click', function(){
            currentIndex = $(this).index();
            var newSrc = $(this).attr('src');
            $('#mainImage, #mainImageDark').attr('src', newSrc);
            $('#thumbnailGrid img.thumb').removeClass('active');
            $(this).addClass('active');
        });
        
        // Left arrow: show previous image and update active thumbnail
        $('#prevBtn').on('click', function(){
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            var newSrc = "{{ asset('storage/') }}" + images[currentIndex];
            $('#mainImage, #mainImageDark').attr('src', newSrc);
            $('#thumbnailGrid img.thumb').removeClass('active');
            $('#thumbnailGrid img.thumb').eq(currentIndex).addClass('active');
            scrollThumbnailIntoView(currentIndex);
        });
        
        // Right arrow: show next image and update active thumbnail
        $('#nextBtn').on('click', function(){
            currentIndex = (currentIndex + 1) % images.length;
            var newSrc = "{{ asset('storage/') }}" + images[currentIndex];
            $('#mainImage, #mainImageDark').attr('src', newSrc);
            $('#thumbnailGrid img.thumb').removeClass('active');
            $('#thumbnailGrid img.thumb').eq(currentIndex).addClass('active');
            scrollThumbnailIntoView(currentIndex);
        });
        
        $('input[name="quantity"]').on('input', function(){
            var max = parseInt($(this).attr('max'));
            var val = parseInt($(this).val());
            if(val >= max){
                $('#quantityMessage').removeClass('hidden').text("You have reached the maximum available stock.");
            } else {
                $('#quantityMessage').addClass('hidden').text("");
            }
        });
    });
    </script>
    <style>
        /* Add border effect on the focused thumbnail */
        #thumbnailGrid img.thumb.active {
            border-color: #ec4899; /* orange-500 */
        }
    </style>
    @endpush
  
</x-layouts.customer-layout>