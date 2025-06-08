<div class="mb-8">
	<nav class="bg-pink dark:data-current:bg-white/[7%] antialiased">
		<div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
			<div class="flex items-center justify-between">

				<div class="flex items-center space-x-8">
					<div class="shrink-0">
						<a href="#" title="" class="">
							<x-app-icon />
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
						{{-- <li>
							<div class="relative">
								<!-- Updated dropdown button using provided styling -->
								<button id="category-dropdown-header" data-dropdown-toggle="productsDropdown"
									type="button"
									class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
									Product
									<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 10 6">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
											stroke-width="2" d="m1 1 4 4 4-4" />
									</svg>
								</button>
								<!-- Updated dropdown container with small paginator -->
								<div id="productsDropdown"
									class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
									<ul id="productsList" class="py-2 text-sm text-gray-700 dark:text-gray-200"> --}}
										{{-- Categories will be loaded via JavaScript --}}
									{{-- </ul>
									@if($categories->count() > 10)
									<div class="py-2 px-4 flex justify-between items-center">
										<button id="prevProducts"
											class="cursor-pointer px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Prev</button>
										<span id="prodPageIndicator"
											class="text-sm text-gray-700 dark:text-gray-200"></span>
										<button id="nextProducts"
											class="cursor-pointer px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Next</button>
									</div>
									@endif
								</div>
							</div>
						</li> --}}
						<li>
							<div class="relative">
								<!-- Updated dropdown button using provided styling -->
								<button id="category-dropdown-header" data-dropdown-toggle="paymentsDropdown"
									type="button"
									class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
									Payment
									<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 10 6">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
											stroke-width="2" d="m1 1 4 4 4-4" />
									</svg>
								</button>
								<!-- Updated dropdown container with small paginator -->
								<div id="paymentsDropdown"
									class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
									<ul id="paymentsList" class="py-2 text-sm text-gray-700 dark:text-gray-200">
										<li>
											<a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['payment_status' => 'pending']) }}">To
												Pay</a>
										</li>
										<li>
											<a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['payment_status' => 'paid']) }}">Paid</a>
										</li>
										<li>
											<a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['payment_status' => 'failed']) }}">Failed</a>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<div class="relative">
								<!-- Updated dropdown button using provided styling -->
								<button id="category-dropdown-header" data-dropdown-toggle="deliveriesDropdown"
									type="button"
									class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
									Delivery
									<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 10 6">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
											stroke-width="2" d="m1 1 4 4 4-4" />
									</svg>
								</button>
								<!-- Updated dropdown container with small paginator -->
								<div id="deliveriesDropdown"
									class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
									<ul id="deliveriesList" class="py-2 text-sm text-gray-700 dark:text-gray-200">
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['delivery_status' => 'pending']) }}">To
												Ship</a></li>
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['delivery_status' => 'shipped']) }}">Shipped</a>
										</li>
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['delivery_status' => 'ofd']) }}">Out
												For Delivery</a></li>
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['delivery_status' => 'delivered']) }}">Delivered</a>
										</li>
									</ul>
								</div>
							</div>
						</li>
						<li>
							<div class="relative">
								<!-- Updated dropdown button using provided styling -->
								<button id="category-dropdown-header" data-dropdown-toggle="ordersDropdown"
									type="button"
									class="cursor-pointer text-gray-900 dark:text-white  hover:text-primary-700  dark:hover:text-primary-500  focus:ring-0 focus:outline-none font-medium rounded-lg text-sm px-2 py-2.5 inline-flex items-center dark:focus:bg-gray-600">
									Order
									<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
										fill="none" viewBox="0 0 10 6">
										<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
											stroke-width="2" d="m1 1 4 4 4-4" />
									</svg>
								</button>
								<!-- Updated dropdown container with small paginator -->
								<div id="ordersDropdown"
									class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
									<ul id="ordersList" class="py-2 text-sm text-gray-700 dark:text-gray-200">
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status') }}">All Orders</a></li>
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['order_status' => 'pending']) }}">Pending
												Orders</a></li>
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['order_status' => 'completed']) }}">Completed
												Orders</a></li>
										<li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600"
												href="{{ route('buyer.orders.order-status', ['order_status' => 'cancelled']) }}">Cancelled
												Orders</a></li>
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

					<a id="sign-in-button" href='{{ Route(' login') }}'
						class="inline-flex btn items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
						<span class="hidden sm:flex">Sign In</span>
						<i class="fa-solid fa-arrow-right-to-bracket w-5 lg:ms-2"></i>
					</a>


					@else
					@hasrole('buyer')
					<button id="myCartDropdownButton1" data-dropdown-toggle="myCartDropdown1" type="button"
						class="hover:cursor-pointer inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
						<span class="sr-only">Cart</span>
						<svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
							height="24" fill="none" viewBox="0 0 24 24">
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
					@endrole

					<button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button"
						class="hover:cursor-pointer inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
						<svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
							height="24" fill="none" viewBox="0 0 24 24">
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

						<button type="button" data-collapse-toggle="ecommerce-navbar-menu-1"
							aria-controls="ecommerce-navbar-menu-1" aria-expanded="false"
							class="inline-flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white">
							<span class="sr-only">
								Open Menu
							</span>
							<svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
								height="24" fill="none" viewBox="0 0 24 24">
								<path stroke="currentColor" stroke-linecap="round" stroke-width="2"
									d="M5 7h14M5 12h14M5 17h14" />
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

</div>