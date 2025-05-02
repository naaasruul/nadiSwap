<x-layouts.customer-layout>
  
  <!-- Section Title -->
  <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12 mx-auto max-w-screen-xl px-4 2xl:px-0">
  @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
        {{ session('success') }}
    </div>
  @endif
    <!-- Heading & Filters -->
      <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
        <div class="flex-1">
          <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
              <li class="inline-flex items-center">
                <a href="{{ route('buyer.dashboard') }}"
                  class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                  <svg class="me-2.5 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                      d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                  </svg>
                  Home
                </a>
              </li>
              @if(isset($recommendedCategoryName) && $recommendedCategoryName && !$isSearchResults &&
              !request('category'))
              <li>
                <div class="flex items-center">
                  <svg class="mx-1 h-3 w-3 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 9 4-4-4-4" />
                  </svg>
                  <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400">{{ $recommendedCategoryName
                    }}</span>
                </div>
              </li>
              @endif
            </ol>
          </nav>

          <!-- Page Title with dynamic content based on what we're showing -->
          <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">
            @if($isSearchResults)
                Search Results for "{{ $searchTerm }}"
            @elseif(request('category'))
                @php
                    $category = \App\Models\Category::find(request('category'));
                    $categoryName = $category ? $category->name : "Products";
                @endphp
                {{ $categoryName }}
            @elseif(isset($recommendedCategoryName) && $recommendedCategoryName)
                Recommended For You
            @else
                All Products
            @endif
          </h2>

          <div class="mt-4 flex flex-col sm:flex-row gap-4">
            <form action="{{ route('buyer.dashboard') }}" method="GET" class="flex-1 flex items-center">
              <label for="search" class="sr-only">Search</label>
              <div class="relative w-full">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                  <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                  </svg>
                </div>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                  class="block w-full rounded-lg border border-gray-300 bg-white p-2.5 pl-10 text-sm text-gray-900 hover:bg-gray-50 focus:border-primary-500 focus:ring-4 focus:ring-primary-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:placeholder:text-gray-400 dark:hover:bg-gray-700 dark:focus:border-primary-500"
                  placeholder="Search products..." />
              </div>
              <button type="submit"
                class="ml-2 inline-flex cursor-pointer items-center rounded-lg border border-gray-300 bg-white p-2.5 text-center text-sm font-medium text-gray-900 hover:bg-gray-50 focus:ring-4 focus:ring-primary-300 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:border-primary-500">
                <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.5 14.5A6 6 0 1 0 8.5 2.5a6 6 0 0 0 0 12Zm11.5 5L14.5 14" />
                </svg>
                <span class="sr-only">Search</span>
              </button>
            </form>

            <!-- Category Filter Dropdown -->
            {{-- <div class="relative z-[5]">
              <!-- Changed from z-10 to z-[5] -->
              <button id="category-dropdown-button"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                <span>Categories</span>
                <svg class="ml-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <div id="category-dropdown"
                class="absolute right-0 z-[5] mt-2 hidden w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-gray-800"
                role="menu" aria-orientation="vertical" aria-labelledby="category-dropdown-button">
                <div class="py-1" role="none">
                  <a href="{{ route('buyer.dashboard') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                    role="menuitem">All Categories</a>

                  <!-- All Categories Section -->
                  <div class="border-t border-gray-100 pt-1 dark:border-gray-700">
                    <span class="block px-4 py-1 text-xs font-medium text-gray-500 dark:text-gray-400">All
                      Categories</span>
                    @if(isset($allCategories))
                    @foreach($allCategories as $category)
                    <a href="{{ route('buyer.dashboard', ['category' => $category->id]) }}"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                      role="menuitem">
                      {{ $category->name }}
                      @if(isset($preferredCategories[$category->id]))
                      <span
                        class="ml-2 inline-flex items-center rounded-full bg-pink-100 px-2 py-0.5 text-xs font-medium text-pink-800 dark:bg-pink-900 dark:text-pink-300">
                        Recommended
                      </span>
                      @endif
                      @foreach($trendingCategories as $trendCat)
                      @if($trendCat['id'] == $category->id)
                      <span
                        class="ml-2 inline-flex items-center rounded-full bg-primary-100 px-2 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                        Popular
                      </span>
                      @endif
                      @endforeach
                    </a>
                    @endforeach
                    @endif
                  </div>
                </div>
              </div>
            </div> --}}
          </div>

          {{-- broken af --}}
          {{-- <!-- Featured Categories Display - New Section -->
          <div class="mt-6 mb-8">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-lg font-medium text-gray-900 dark:text-white">Featured Categories</h3>
              <a href="{{ route('buyer.all_categories') }}"
                class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
                View all
              </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
              @if(isset($trendingCategories))
              @foreach($trendingCategories->take(6) as $category)
              <a href="{{ route('buyer.dashboard', ['category' => $category['id']]) }}"
                class="category-card flex flex-col items-center justify-center p-4 border border-gray-200 rounded-lg bg-white hover:bg-gray-50 transition-all dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <span class="text-sm font-medium text-center text-gray-900 dark:text-white">{{ $category['name'] }}</span>
                @if(isset($category['count']))
                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $category['count'] }} products</span>
                @endif
              </a>
              @endforeach
              @endif
            </div>
          </div> --}}

          <!-- Recommendation Section (Only show if there's a recommended category) -->
          @if(isset($recommendedCategory) && $recommendedCategory && !$isSearchResults && !request('category'))
          <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center">
              <div
                class="recommendation-badge inline-flex items-center justify-center rounded-lg bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                  viewBox="0 0 20 18">
                  <path
                    d="M17.947 2.053a5.209 5.209 0 0 0-3.793-1.53A6.414 6.414 0 0 0 10 2.311 6.482 6.482 0 0 0 5.824.5a5.2 5.2 0 0 0-3.8 1.521c-1.915 1.916-2.315 5.392.625 8.333l7 7a.5.5 0 0 0 .708 0l7-7a6.605 6.605 0 0 0 2.043-4.773 5.145 5.145 0 0 0-1.453-3.528Z" />
                </svg>
              </div>
              <h3 class="ml-2 text-lg font-bold text-primary-700 dark:text-primary-400">
                Personalized for you: {{ $recommendedCategoryName }}
              </h3>
            </div>
            <form action="{{ route('buyer.reset_recommendations') }}" method="POST">
              @csrf
              <button type="submit"
                class="hover:cursor-pointer inline-flex items-center rounded-lg border border-red-600 bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-2"
                  viewBox="0 0 16 16">
                  <path
                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                  <path
                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                </svg>
                Reset Recommendations
              </button>
            </form>
          </div>
          @endif
        </div>
      </div>

      <!-- Products Grid -->
      <div class="mx-auto max-w-screen-xl 2xl:px-0">
        @if($isSearchResults && $products->count() > 0)
        <!-- Direct Matches Section -->
        @php
        $directMatches = $products->filter(function($product) {
        return $product->is_direct_match ?? false;
        });
        @endphp

        @if($directMatches->count() > 0)
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Products Matching "{{ $searchTerm }}"</h3>
        <div class="products-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-8">
          @foreach($directMatches as $product)
          @include('components.product-card', ['product' => $product])
          @endforeach
        </div>
        @endif

        <!-- Recommendations Section -->
        @php
        $recommendations = $products->filter(function($product) {
        return !($product->is_direct_match ?? true);
        });
        @endphp

        @if($recommendations->count() > 0)
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Similar Products You Might Like</h3>
        <div class="products-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          @foreach($recommendations as $product)
          @include('components.product-card', ['product' => $product])
          @endforeach
        </div>
        @endif
        @else
        <div class="products-grid grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
          @if($products->count() > 0)
          @foreach($products as $product)
          @include('components.product-card', ['product' => $product])
          @endforeach
          @else
          <div
            class="col-span-full flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-8 text-center shadow dark:border-gray-700 dark:bg-gray-800">
            <svg class="mb-4 h-12 w-12 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">No products found</h3>
            <p class="text-gray-500 dark:text-gray-400">Try adjusting your search or filter to find what you're looking
              for.</p>
            <a href="{{ route('buyer.dashboard') }}"
              class="mt-4 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
              View all products
            </a>
          </div>
          @endif
        </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-8 mx-auto max-w-screen-xl px-4 2xl:px-0">
      <x-paginator :paginator="$products" />
    </div>
  </section>
  <script>
    $(document).ready(function() {
        // Enhanced category dropdown with animation
        const categoryButton = $('#category-dropdown-button');
        const categoryDropdown = $('#category-dropdown');
        
        categoryButton.on('click', function(e) {
            e.preventDefault();
            categoryDropdown.slideToggle(200);
        });

        $(document).on('click', function(e) {
          setTimeout(function() {
              if (
                  !categoryButton.is(e.target) &&
                  categoryButton.has(e.target).length === 0 &&
                  !categoryDropdown.is(e.target) &&
                  categoryDropdown.has(e.target).length === 0
              ) {
                  categoryDropdown.slideUp(200);
              }
          }, 0);
      });


        // Automatically close dropdown when a link is clicked
        categoryDropdown.find('a').on('click', function() {
            categoryDropdown.slideUp(200);
        });

        // Mobile filter drawer with smooth animation
        const filterButton = $('#mobile-filter-button');
        const filterDrawer = $('#mobile-filter-drawer');
        const closeFilterButton = $('#close-filter-drawer');
        
        filterButton.on('click', function() {
            filterDrawer.fadeIn(300);
            filterDrawer.find('div:last-child').animate({right: '0'}, 300);
        });
        
        const closeDrawer = function() {
            filterDrawer.find('div:last-child').animate({right: '-100%'}, 300, function() {
                filterDrawer.fadeOut(200);
            });
        };
        
        closeFilterButton.on('click', closeDrawer);
        
        filterDrawer.on('click', function(e) {
            if ($(e.target).is(filterDrawer)) {
                closeDrawer();
            }
        });

        // Improved hover effects and cart functionality
        $('.product-card').hover(
            function() {
                $(this).addClass('shadow-lg border-primary-100 dark:border-primary-900').removeClass('shadow-sm');
            },
            function() {
                $(this).removeClass('shadow-lg border-primary-100 dark:border-primary-900').addClass('shadow-sm');
            }
        );

        // Enhanced cart button animation
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            const btn = $(this);
            const form = btn.closest('form');
            const loadingText = btn.find('.loading-text');
            const productName = btn.closest('.product-card').find('.product-name').text().trim();
            
            // Disable button and show loading state
            btn.prop('disabled', true).addClass('opacity-75 cursor-not-allowed');
            loadingText.html('<svg class="animate-spin -ml-1 mr-2 h-5 w-5 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 1 0 8-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Adding...');
            
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    showToast(`${productName} added to cart!`, 'success');
                    // Update only the cart items content
                    $("#myCartDropdown1 #cart-items").html(response);
                },
                error: function() {
                    showToast('Could not add to cart. Please try again.', 'error');
                },
                complete: function() {
                    btn.prop('disabled', false).removeClass('opacity-75 cursor-not-allowed');
                    loadingText.html('Add to Cart');
                    btn.addClass('bg-green-500 text-white').delay(500).queue(function(next) {
                        $(this).removeClass('bg-green-500 text-white');
                        next();
                    });
                }
            });
        });

        // Function to show toast notifications
        function showToast(message, type = 'info') {
            // Check if we already have a toast container
            let toastContainer = $('#toast-container');
            if (toastContainer.length === 0) {
                toastContainer = $('<div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col gap-2"></div>');
                $('body').append(toastContainer);
            }
            
            // Create the toast element
            const toast = $(`
                <div class="flex items-center p-4 mb-4 rounded-lg shadow ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}" role="alert">
                    <div class="text-sm font-medium">${message}</div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 ${type === 'success' ? 'bg-green-100 text-green-500 hover:bg-green-200' : 'bg-red-100 text-red-500 hover:bg-red-200'}" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `);
            
            // Add the toast to the container
            toastContainer.append(toast);
            
            // Remove the toast after 3 seconds
            setTimeout(function() {
                toast.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
            
            // Close button functionality
            toast.find('button').on('click', function() {
                toast.fadeOut(300, function() {
                    $(this).remove();
                });
            });
        }

        // Load more products with AJAX functionality
        $('#load-more').on('click', function() {
            const btn = $(this);
            const productsGrid = $('.products-grid');
            const page = parseInt(btn.data('page') || 1) + 1;
            
            // Show loading state
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            
            // Make AJAX request to get more products
            $.ajax({
                url: window.location.pathname,
                method: 'GET',
                data: {
                    page: page,
                    search: $('input[name="search"]').val(),
                    category: new URLSearchParams(window.location.search).get('category')
                },
                success: function(response) {
                    // Parse the HTML response
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const newProducts = $(doc).find('.products-grid > div');
                    
                    // Check if we got any new products
                    if (newProducts.length > 0) {
                        // Append new products to the grid
                        productsGrid.append(newProducts);
                        btn.data('page', page);
                        
                        // Reset button state
                        btn.prop('disabled', false).text('Show more');
                        
                        // Apply hover effects to new products
                        $('.product-card').hover(
                            function() {
                                $(this).addClass('shadow-lg border-primary-100 dark:border-primary-900').removeClass('shadow-sm');
                            },
                            function() {
                                $(this).removeClass('shadow-lg border-primary-100 dark:border-primary-900').addClass('shadow-sm');
                            }
                        );
                    } else {
                        // No more products to load
                        btn.text('No more products').prop('disabled', true);
                    }
                },
                error: function() {
                    btn.prop('disabled', false).text('Try again');
                }
            });
        });

        // Highlight current category in the dropdown
        const currentCategory = new URLSearchParams(window.location.search).get('category');
        if (currentCategory) {
            $(`#category-dropdown a[href*="category=${currentCategory}"]`).addClass('bg-gray-100 text-primary-700 dark:bg-gray-700 dark:text-white');
        }
        
        // Enhanced recommendation display with animation
        if ($('.recommendation-badge').length) {
            $('.recommendation-badge').addClass('animate-pulse');
            setTimeout(function() {
                $('.recommendation-badge').removeClass('animate-pulse');
            }, 2000);
        }
    });
  </script>
</x-layouts.customer-layout>