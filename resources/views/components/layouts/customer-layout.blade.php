<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NadiSwap</title>
  @include('partials.head')
</head>

<body class="bg-gray-50 dark:bg-gray-900 antialiased">
  @php
      use App\Models\Category;
      $categories = Category::all();
  @endphp
  <nav class="bg-pink dark:bg-gray-800 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
      <div class="flex items-center justify-between">

        <div class="flex items-center space-x-8">
          <div class="shrink-0">
            <a href="#" title="" class="">
              <x-app-icon/>
            </a>
          </div>
          <ul class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
            @hasrole('buyer')
            <li>
              <a href="{{ Route('buyer.dashboard') }}" title=""
                class="flex text-sm font-medium px-2 py-2.5 text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                Home
              </a>
            </li>
            {{-- <li>
              <a href="{{ Route('buyer.dashboard') }}" title=""
                class="flex text-sm font-medium px-2 py-2.5 text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                Shop
              </a>
            </li> --}}
            <li>
              <div class="relative">
                <!-- Updated dropdown button using provided styling -->
                <button id="category-dropdown-header" data-dropdown-toggle="productsDropdown" type="button" class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
                  Product
                  <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
                </button>
                <!-- Updated dropdown container with small paginator -->
                <div id="productsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                  <ul id="productsList" class="py-2 text-sm text-gray-700 dark:text-gray-200">
                    {{-- Categories will be loaded via JavaScript --}}
                  </ul>
                  @if($categories->count() > 10)
                  <div class="py-2 px-4 flex justify-between items-center">
                    <button id="prevProducts" class="cursor-pointer px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Prev</button>
                    <span id="prodPageIndicator" class="text-sm text-gray-700 dark:text-gray-200"></span>
                    <button id="nextProducts" class="cursor-pointer px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Next</button>
                  </div>
                  @endif
                </div>
              </div>
            </li>
            <li>
            <div class="relative">
              <!-- Updated dropdown button using provided styling -->
              <button id="category-dropdown-header" data-dropdown-toggle="paymentsDropdown" type="button" class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
                Payment
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
              </button>
              <!-- Updated dropdown container with small paginator -->
              <div id="paymentsDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                <ul id="paymentsList" class="py-2 text-sm text-gray-700 dark:text-gray-200">
                  <li>
                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['payment_status' => 'pending']) }}">To Pay</a>
                  </li>
                  <li>
                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['payment_status' => 'paid']) }}">Paid</a>
                  </li>
                  <li>
                    <a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['payment_status' => 'failed']) }}">Failed</a>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <div class="relative">
              <!-- Updated dropdown button using provided styling -->
              <button id="category-dropdown-header" data-dropdown-toggle="deliveriesDropdown" type="button" class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
                Delivery
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
              </button>
              <!-- Updated dropdown container with small paginator -->
              <div id="deliveriesDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                <ul id="deliveriesList" class="py-2 text-sm text-gray-700 dark:text-gray-200">
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['delivery_status' => 'pending']) }}">To Ship</a></li>
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['delivery_status' => 'shipped']) }}">Shipped</a></li>
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['delivery_status' => 'ofd']) }}">Out For Delivery</a></li>
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['delivery_status' => 'delivered']) }}">Delivered</a></li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <div class="relative">
              <!-- Updated dropdown button using provided styling -->
              <button id="category-dropdown-header" data-dropdown-toggle="ordersDropdown" type="button" class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
                Order
                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
              </button>
              <!-- Updated dropdown container with small paginator -->
              <div id="ordersDropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                <ul id="ordersList" class="py-2 text-sm text-gray-700 dark:text-gray-200">
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status') }}">All Orders</a></li>
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['order_status' => 'pending']) }}">Pending Orders</a></li>
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['order_status' => 'completed']) }}">Completed Orders</a></li>
                  <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="{{ route('buyer.orders.order-status', ['order_status' => 'cancelled']) }}">Cancelled Orders</a></li>
                </ul>
              </div>
            </div>
          </li>
            <li>
              <a href="{{ Route('contact.index') }}" title=""
                class="flex text-sm font-medium px-2 py-2.5 text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                Contact
              </a>
            </li>
            @endrole
          </ul>
        </div>
        <div class="flex items-center lg:space-x-2">
          @if(!Auth::check())

          <a id="sign-in-button" href='{{ Route('login') }}'
            class="inline-flex btn items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
            <span class="hidden sm:flex">Sign In</span>
            <i class="fa-solid fa-arrow-right-to-bracket w-5 lg:ms-2"></i>
          </a>


          @else
          @hasrole('buyer')
          <button id="myCartDropdownButton1" data-dropdown-toggle="myCartDropdown1" type="button"
            class="hover:cursor-pointer inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
            <span class="sr-only">Cart</span>
            <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
            </svg>
            <span class="hidden sm:flex ">My Cart</span>
            <svg class="hidden sm:flex w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 9-7 7-7-7" />
            </svg>
          </button>

          <div id="myCartDropdown1"
          class="hidden z-10 absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg p-4 dark:bg-gray-800">
          @include('partials.cart-items')
        </div>
          @endrole()

          <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button"
            class="hover:cursor-pointer inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
            <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-width="2"
                d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
            Account
            <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m19 9-7 7-7-7" />
            </svg>
          </button>


          <div id="userDropdown1"
            class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
            <ul class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white">
              <li>
                <p title=""
                  class="inline-flex w-full text-gray-500 dark:text-gray-400 items-center gap-2 rounded-md px-3 py-2 text-sm">
                  Hi, {{ Auth::user()->name }}! </p>
              </li>
              <li>
                @hasrole('buyer')
                <a href="{{ Route('settings.profile') }}" title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                  My Account
                </a>
                @endrole
                @hasrole('seller')
                <a href="{{ Route('seller.dashboard') }}" title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                  My Account 
                </a>
                @endrole
                @hasrole('admin')
                <a href="{{ Route('admin.dashboard') }}" title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                  My Account 
                </a>
                @endrole

                </li>
            </ul>
            <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
              <form action="{{ Route('logout') }}" method="POST">
                @csrf
                <button type="submit" title=""
                  class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                  Sign Out </button>
              </form>
            </div>
          @endif

          <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1" aria-controls="ecommerce-navbar-menu-1"
            aria-expanded="false"
            class="inline-flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white">
            <span class="sr-only">
              Open Menu
            </span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
              fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
            </svg>
          </button>
        </div>
      </div>

      <div id="ecommerce-navbar-menu-1"
        class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4">
        <ul class="text-gray-900 text-sm font-medium dark:text-white space-y-3">
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Home</a>
          </li>
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Best Sellers</a>
          </li>
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Gift Ideas</a>
          </li>
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Games</a>
          </li>
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Electronics</a>
          </li>
          <li>
            <a href="#" class="hover:text-primary-700 dark:hover:text-primary-500">Home & Garden</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- <div id="default-carousel" class="relative w-full z-0" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-full overflow-hidden md:h-96">
      <!-- Item 1 -->
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img
          src="https://images.unsplash.com/photo-1695073621086-aa692bc32a3d?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8bmlrZSUyMHNob2V8ZW58MHx8MHx8fDA%3D"
          class="absolute block w-full  -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
      </div>
      <!-- Item 2 -->
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img
          src="https://images.unsplash.com/photo-1670105084645-d4e3c9800776?q=80&w=1956&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          class="absolute block w-full  -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
      </div>
      <!-- Item 3 -->
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img
          src="https://images.unsplash.com/photo-1600269452121-4f2416e55c28?q=80&w=1965&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          class="absolute block w-full  -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
      </div>
      <!-- Item 4 -->
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img
          src="https://images.unsplash.com/photo-1711719745936-ff93f602246e?q=80&w=2013&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          class="absolute block w-full  -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
      </div>
      <!-- Item 5 -->
      <div class="hidden duration-700 ease-in-out" data-carousel-item>
        <img
          src="https://images.unsplash.com/photo-1539185441755-769473a23570?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          class="absolute block w-full  -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
      </div>
    </div>
    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
      <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
        data-carousel-slide-to="0"></button>
      <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
        data-carousel-slide-to="1"></button>
      <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
        data-carousel-slide-to="2"></button>
      <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
        data-carousel-slide-to="3"></button>
      <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
        data-carousel-slide-to="4"></button>
    </div>
    <!-- Slider controls -->
    <button type="button"
      class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      data-carousel-prev>
      <span
        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 1 1 5l4 4" />
        </svg>
        <span class="sr-only">Previous</span>
      </span>
    </button>
    <button type="button"
      class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
      data-carousel-next>
      <span
        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 9 4-4-4-4" />
        </svg>
        <span class="sr-only">Next</span>
      </span>
    </button>
  </div> --}}
  @stack('modal')
  {{ $slot }}
  <script>
    $(document).ready(function(){
      // Highlight current category in the dropdown
      const currentCategory = new URLSearchParams(window.location.search).get('category');
      if (currentCategory) {
        $('#category-dropdown-header a[href*="category=' + currentCategory + '"]').addClass('bg-gray-100 text-primary-700 dark:bg-gray-700 dark:text-white');
      }

      // Paginator for product categories dropdown using jQuery
      var categories = @json($categories);
      var perPage = 10;
      var currentPage = 1;
      var totalPages = Math.ceil(categories.length / perPage);
      function renderCategoriesPage(page) {
        var start = (page - 1) * perPage;
        var end = start + perPage;
        var pagedCategories = categories.slice(start, end);
        var productsList = $('#productsList');
        productsList.empty();
        $.each(pagedCategories, function(index, category) {
          productsList.append("<li><a href='{{ route('buyer.dashboard') }}?category=" + category.id + "' class='block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600'>" + category.name + "</a></li>");
        });
        $('#prodPageIndicator').text(page + " / " + totalPages);
        $('#prevProducts').prop("disabled", page === 1);
        $('#nextProducts').prop("disabled", page === totalPages);
      }
      $('#prevProducts').on('click', function(){
        if(currentPage > 1) {
          currentPage--;
          renderCategoriesPage(currentPage);
        }
      });
      $('#nextProducts').on('click', function(){
        if(currentPage < totalPages) {
          currentPage++;
          renderCategoriesPage(currentPage);
        }
      });
      renderCategoriesPage(currentPage);
    });
  </script>
  @stack('js')
</body>


<footer class="rounded-lg shadow-sm m-4">
  <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
      <a href="https://flowbite.com/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
        <x-app-icon/>
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Nadiswap</span>
      </a>
      {{-- <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
        <li>
          <a href="#" class="hover:underline me-4 md:me-6">About</a>
        </li>
        <li>
          <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
        </li>
        <li>
          <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
        </li>
        <li>
          <a href="#" class="hover:underline">Contact</a>
        </li>
      </ul> --}}
    </div>
    <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
    <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#"
        class="hover:underline">Nadiswap™</a>. All Rights Reserved.</span>
  </div>
</footer>


</html>