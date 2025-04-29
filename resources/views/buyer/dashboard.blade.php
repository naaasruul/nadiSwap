<x-layouts.customer-layout>
  <!-- Section Title -->
  <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
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
            $categoryName = "Products";
            foreach($trendingCategories as $cat) {
            if($cat['id'] == request('category')) {
            $categoryName = $cat['name'];
            break;
            }
            }
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
                <svg class="h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 14.5A6 6 0 1 0 8.5 2.5a6 6 0 0 0 0 12Zm11.5 5L14.5 14"/>
                </svg>
                <span class="sr-only">Search</span>
              </button>
            </form>

            <!-- Category Filter Dropdown -->
            <div class="relative z-[5]">  <!-- Changed from z-10 to z-[5] -->
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
                    <span class="block px-4 py-1 text-xs font-medium text-gray-500 dark:text-gray-400">All Categories</span>
                    @if(isset($allCategories))
                      @foreach($allCategories as $category)
                        <a href="{{ route('buyer.dashboard', ['category' => $category->id]) }}"
                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                          role="menuitem">
                          {{ $category->name }}
                          @if(isset($preferredCategories[$category->id]))
                            <span class="ml-2 inline-flex items-center rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                              Recommended
                            </span>
                          @endif
                          @foreach($trendingCategories as $trendCat)
                            @if($trendCat['id'] == $category->id)
                              <span class="ml-2 inline-flex items-center rounded-full bg-primary-100 px-2 py-0.5 text-xs font-medium text-primary-800 dark:bg-primary-900 dark:text-primary-300">
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
            </div>
          </div>

          <!-- Featured Categories Display - New Section -->
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
          </div>

          <!-- Recommendation Section (Only show if there's a recommended category) -->
          @if(isset($recommendedCategory) && $recommendedCategory && !$isSearchResults && !request('category'))
          <div class="mt-4 flex items-center justify-between">
            <div class="flex items-center">
              <div
                class="recommendation-badge inline-flex h-8 w-8 items-center justify-center rounded-lg bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
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
                class="inline-flex items-center rounded-lg border border-red-600 bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 4v5h.582M20 20v-5h-.581M5.635 19A9 9 0 1 1 19 5.635" />
                </svg>
                Reset Recommendations
              </button>
            </form>
          </div>
          @endif
        </div>
      </div>

      <!-- Products Grid -->
      <div class="mb-4">
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
              <div class="col-span-full flex flex-col items-center justify-center rounded-lg border border-gray-200 bg-white p-8 text-center shadow dark:border-gray-700 dark:bg-gray-800">
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

      <!-- Pagination/Show More -->
      @if($products->count() > 0)
      <div class="mt-6 flex justify-center w-full">
        @if(method_exists($products, 'links') && !$products instanceof \Illuminate\Database\Eloquent\Collection)
        {{ $products->links() }}
        @else
        <button id="load-more" type="button"
          class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
          Show more
        </button>
        @endif
      </div>
      @endif
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

        // Recommended products section - add hover effects
        $('.product-card').hover(
            function() {
                $(this).find('.quick-add-button').fadeIn(200);
                $(this).addClass('shadow-lg').removeClass('shadow-sm');
            },
            function() {
                $(this).find('.quick-add-button').fadeOut(200);
                $(this).removeClass('shadow-lg').addClass('shadow-sm');
            }
        );

        // Add to cart button with animation
        $('.add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            const productName = $(this).closest('.product-card').find('.product-name').text().trim();
            
            // Show loading state
            $(this).prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');
            
            // Submit form via AJAX
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    // Update cart count in header (assuming you have a cart counter element)
                    if (response.cartCount) {
                        $('#cart-count').text(response.cartCount);
                    }
                    
                    // Show success message
                    showToast(`${productName} added to cart!`, 'success');
                },
                error: function() {
                    showToast('Could not add to cart. Please try again.', 'error');
                },
                complete: function() {
                    // Reset button state
                    $('.add-to-cart-btn').prop('disabled', false).html('<svg class="mr-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7v14" /></svg> Add');
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
                                $(this).find('.quick-add-button').fadeIn(200);
                                $(this).addClass('shadow-lg').removeClass('shadow-sm');
                            },
                            function() {
                                $(this).find('.quick-add-button').fadeOut(200);
                                $(this).removeClass('shadow-lg').addClass('shadow-sm');
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