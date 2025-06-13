<x-layouts.customer-layout>

    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Shopping Cart</h2>

            @php
                // Determine if any cart item has no shipping options
                $disableCheckout = false;
                foreach($cartItems as $item) {
                    if($item['shippings']->isEmpty()){
                        $disableCheckout = true;
                        break;
                    }
                }
            @endphp

            <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
                <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
                    @if (empty($cartItems))
                    <p class="text-gray-500 dark:text-gray-400">Your cart is empty.</p>
                    @else
                    <div class="space-y-6">
                        @foreach ($cartItems as $id => $item)
                        <div
                            class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                            <div class="flex justify-end">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="hover:cursor-pointer inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                        <svg class="me-1.5 h-5 w-5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </div>
                            <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                                <!-- Product Image -->
                                <a href="#" class="shrink-0 md:order-1">
                                    <img class="h-32 w-32 object-cover rounded-lg" src="{{ asset('storage/'.$item['image']) }}"
                                        alt="{{ $item['name'] }}" />
                                </a>

                                <!-- Quantity Controls -->
                                <div class="flex items-center justify-between md:order-3 md:justify-end">
                                    <div class="flex flex-col items-center">
                                        <div class="flex items-center">
                                            <!-- Minus Button -->
                                            <button type="button"
                                                class="btn-minus hover:cursor-pointer inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M1 1h16" />
                                                </svg>
                                            </button>
                                            <!-- Quantity Input: added data-stock -->
                                            <input id="quantity-{{ $id }}" data-price="{{ $item['price'] }}" data-stock="{{ $productStock }}" type="text"
                                                value="{{ $item['quantity'] }}"
                                                class="quantity-input w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white"
                                                readonly />
                                            <!-- Plus Button -->
                                            <button type="button"
                                                class="btn-plus hover:cursor-pointer inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                                <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-end md:order-4 md:w-32">
                                        <!-- New price (including shipping) -->
                                        <p id="price-change-{{ $id }}" class="text-base font-bold text-gray-900 dark:text-white"></p>
                                        <!-- Original price (without shipping) -->
                                        <p id="price-display-{{ $id }}" class="price-change text-sm text-gray-500">
                                            RM{{ number_format($item['price'] * $item['quantity'], 2) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Product Details -->
                                <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                    <a href="#"
                                        class="text-base font-medium text-gray-900 hover:underline dark:text-white">{{
                                        $item['name'] }}</a>
                                        <!-- New message element -->
                                    <p id="limit-msg-{{ $id }}" class="text-red-600 text-xs mt-1 hidden">Maximum available stock reached.</p>

                                    {{-- Shipping dropdown updated with data attributes --}}
                                    @if($item['shippings']->isNotEmpty())
                                    <div class="mt-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                            Shipping Area
                                        </label>
                                        <select name="shipping[{{ $id }}]"
                                            class="shipping-select hover:cursor-pointer mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            data-quantity="{{ $item['quantity'] }}">
                                            @foreach ($item['shippings'] as $shipping)
                                            <option value="{{ $shipping->id }}"
                                                data-fee="{{ $shipping->shipping_fee }}">
                                                {{ $shipping->place }} - RM{{ number_format($shipping->shipping_fee, 2)
                                                }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <div class="mt-2 text-red-600 text-sm">
                                        This item is not available for the time being
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                @php
                $productsTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cartItems));
                $shippingTotal = array_sum(array_map(fn($item) => $item['selected_shipping_fee'],
                $cartItems));
                $grandTotal = $productsTotal + $shippingTotal;
                @endphp

                <!-- Hidden element to pass product total to JS -->
                <span id="productTotal" data-total="{{ $productsTotal }}" class="hidden"></span>

                <!-- Order Summary Section -->
                <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
                    <div
                        class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                        <p class="text-xl font-semibold text-gray-900 dark:text-white">Order summary</p>
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Total Items</dt>
                                    <dd class="text-base font-medium text-gray-900 dark:text-white">{{ count($cartItems)
                                        }}</dd>
                                </dl>
                                <dl
                                    class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Products Total
                                    </dt>
                                    <dd id="productTotalDisplay"
                                        class="text-base font-medium text-gray-900 dark:text-white">
                                        RM{{ number_format($productsTotal, 2) }}
                                    </dd>
                                </dl>
                                <dl
                                    class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                    <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Shipping Total
                                    </dt>
                                    <dd id="shippingTotal" class="text-base font-medium text-gray-900 dark:text-white">
                                        RM{{ number_format($shippingTotal, 2) }}
                                    </dd>
                                </dl>
                                <dl
                                    class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                    <dt class="text-base font-bold text-gray-900 dark:text-white">Grand Total</dt>
                                    <dd id="grandTotal" class="text-base font-bold text-gray-900 dark:text-white">
                                        RM{{ number_format($grandTotal, 2) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>

                        <!-- Checkout Form including hidden quantity inputs and Payment Method Dropdown -->
                        <form action="{{ route('cart.checkout') }}" enctype="multipart/form-data" method="POST" class="mt-6">
                            @csrf
                            <!-- Delivery Address Section Outside of Order Summary Box -->
                            <div class="mx-auto max-w-screen-xl 2xl:px-0 mt-6">
                                @if($addresses->isEmpty())
                                <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded">
                                    Warning: You have no delivery addresses. Please <a class="underline font-bold" href="{{ route('settings.addresses') }}#delivery-addresses">add one.</a>
                                </div>
                                @endif
                                <div>
                                    <label for="delivery_address"
                                        class="block text-base font-medium text-gray-900 dark:text-white">
                                        Delivery Address
                                    </label>
                                    <select id="delivery_address" name="delivery_address"
                                        class="hover:cursor-pointer mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        @if($addresses->isEmpty())
                                        <option value="">No addresses available</option>
                                        @else
                                        @foreach($addresses as $address)
                                        <option value="{{ $address->id }}">
                                            {{ $address->address_line_1 }}@if($address->address_line_2), {{
                                            $address->address_line_2 }}@endif, {{ $address->city }}, {{ $address->state
                                            }}, {{ $address->postal_code }}, {{ $address->country }}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <!-- Hidden inputs for updated cart quantities -->
                            @foreach($cartItems as $id => $item)
                            <input type="hidden" class="hidden-cart-quantity" id="hidden-cart-quantity-{{ $id }}"
                                name="cart[{{ $id }}][quantity]" value="{{ $item['quantity'] }}">
                            <!-- New hidden input for shipping selection -->
                            <input type="hidden" class="hidden-shipping" id="hidden-shipping-{{ $id }}"
                                name="shipping[{{ $id }}]" value="">
                            @endforeach
                            <div class="mt-4">
                                <label for="payment_method"
                                    class="block text-base font-medium text-gray-900 dark:text-white">
                                    Payment Method
                                </label>
                                <select id="payment_method" name="payment_method"
                                    class="mb-6 hover:cursor-pointer mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    {{-- <option value="qr">QR Payment</option> --}}
                                    <option value="cod">Cash On Delivery</option>
                                    <option value="online_banking">Online Banking</option>
                                </select>
                            </div>

                            {{-- display acc number seller --}}
                            <div id='bank_acc_details' class="mt-4 mb-2 hidden">
                              @if($seller && $seller->bank_acc_name != null)
                            <p class='text-xl font-extrabold uppercase'>{{ $seller->bank_acc_name ?? 'Unknown' }}</p>
                            <p class='text-lg font-bold uppercase'>{{ $seller->bank_acc_number ?? 'Unknown' }}</p>
                            <p class='text-lg font-bold uppercase'>{{ $seller->bank_type ?? 'Unknown' }}</p>
                           <div id='send_receipt' class="mt-4 mb-4 hidden">
                                    <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Send Receipt
                                    </label>
                                    <input id='file_receipt' name='file_receipt'
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-pink-50 dark:text-gray-400 focus:outline-none dark:bg-pink-700 dark:border-gray-600 dark:placeholder-pink-400"
                                        type="file">
                            </div>
                         
                            @else
                            <p class='text-xl font-extrabold uppercase text-red-600'>Online Banking Is Not Avalaible</p>
                            @endif
                            </div>
                               <button type="submit"
                                class="{{ ($addresses->isEmpty() || $disableCheckout) ? 'hover:cursor-not-allowed text-white bg-pink-400 dark:bg-pink-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center' : 'hover:cursor-pointer text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-pink-600 dark:hover:bg-pink-700 focus:outline-none dark:focus:ring-pink-800' }} w-full"
                                @if($addresses->isEmpty() || $disableCheckout) disabled @endif>
                                Proceed to Checkout
                            </button>
                      
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Updated JavaScript to make quantity buttons functional -->
    <script>
        document.addEventListener('DOMContentLoaded', function(){
        function recalcTotals() {
            let productSubtotal = 0;
            let shippingTotal = 0;
            const sellerShippingFees = {}; // Track shipping fees per seller

            // Update each item's total including shipping fee
            document.querySelectorAll('.quantity-input').forEach(function(input) {
                const price = parseFloat(input.dataset.price) || 0;
                const qty = parseInt(input.value) || 0;
                const id = input.id.split('-')[1];
                let fee = 0;
                const sellerId = input.dataset.seller; // Add a data attribute for seller ID
                let shippingSelect = document.querySelector(`select[name="shipping[${id}]"]`);
                if (shippingSelect) {
                    fee = parseFloat(shippingSelect.options[shippingSelect.selectedIndex].getAttribute('data-fee')) || 0;
                    // Update the item total display = (price + fee)*qty
                    const priceDisplay = input.closest('.flex.items-center').parentElement.querySelector('.text-end .text-base.font-bold');
                    const priceChangeDisplay = document.getElementById(`price-change-${id}`);
                    if (priceDisplay) {
                        priceDisplay.innerText = 'RM' + (price * qty).toFixed(2);
                    }
                    if (priceChangeDisplay) {
                        priceChangeDisplay.innerText = 'RM' + ((price + fee) * qty).toFixed(2);
                    }
                    // Update hidden shipping input with selected shipping id
                    const hiddenShipping = document.getElementById(`hidden-shipping-${id}`);
                    if(hiddenShipping) {
                        hiddenShipping.value = shippingSelect.value;
                    }
                }
                productSubtotal += price * qty;
                shippingTotal += fee;
            });
            document.getElementById('productTotalDisplay').innerText = 'RM' + productSubtotal.toFixed(2);
            document.getElementById('shippingTotal').innerText = 'RM' + shippingTotal.toFixed(2);
            document.getElementById('grandTotal').innerText = 'RM' + (productSubtotal + shippingTotal).toFixed(2);
        }

        function updateQuantity(button, increment) {
            const container = button.closest('.flex.items-center');
            const quantityInput = container.querySelector('.quantity-input');
            const id = quantityInput.id.split('-')[1];
            const stock = parseInt(quantityInput.getAttribute('data-stock')) || Infinity;
            const price = parseFloat(quantityInput.dataset.price);
            let quantity = parseInt(quantityInput.value);
            const messageElem = document.getElementById(`limit-msg-${id}`);

            if (increment > 0) {
                if (quantity < stock) {
                    quantity = quantity + 1;
                }
                // Ensure we do not exceed stock
                if (quantity >= stock) {
                    quantity = stock;
                    messageElem.classList.remove('hidden');
                    messageElem.innerText = "Maximum available stock reached.";
                } else {
                    messageElem.classList.add('hidden');
                    messageElem.innerText = "";
                }
            } else if (increment < 0) {
                quantity = Math.max(1, quantity + increment);
                // Hide limit message if quantity falls below stock
                if (quantity < stock) {
                    messageElem.classList.add('hidden');
                    messageElem.innerText = "";
                }
            }
            quantityInput.value = quantity;
            
            // Update shipping select if exists
            const shippingSelect = document.querySelector(`select[name="shipping[${id}]"]`);
            if(shippingSelect) {
                shippingSelect.setAttribute('data-quantity', quantity);
            }
            
            // Update price displays
            const priceDisplay = button.closest('.flex.items-center').parentElement.querySelector('.text-end .text-base.font-bold');
            const priceChangeDisplay = document.getElementById(`price-change-${id}`);
            if(priceDisplay) {
                priceDisplay.innerText = 'RM' + (price * quantity).toFixed(2);
            }
            if(priceChangeDisplay && shippingSelect) {
                const fee = parseFloat(shippingSelect.options[shippingSelect.selectedIndex].getAttribute('data-fee')) || 0;
                priceChangeDisplay.innerText = 'RM' + ((price + fee) * quantity).toFixed(2);
            }
            
            // Update hidden input for checkout
            const hiddenInput = document.getElementById(`hidden-cart-quantity-${id}`);
            if(hiddenInput) {
                hiddenInput.value = quantity;
            }
            recalcTotals();
        }

        document.querySelectorAll('.btn-minus').forEach(function(button){
            button.addEventListener('click', function(){
                updateQuantity(button, -1);
            });
        });

        document.querySelectorAll('.btn-plus').forEach(function(button){
            button.addEventListener('click', function(){
                updateQuantity(button, 1);
            });
        });

        document.querySelectorAll('.shipping-select').forEach(function(select){
            select.addEventListener('change', recalcTotals);
        });

        recalcTotals();
    });
    </script>

    <script>
        $(function(){
            $("#payment_method").change(function (e) { 
                e.preventDefault();
                var selectedVal = $(this).val();
                var send_receipt_status = false;
                if(selectedVal !== 'cod'){
                    $('#send_receipt').removeClass('hidden');
                    $('#bank_acc_details').removeClass('hidden');
                    $('#file_receipt').prop('required',true);
                    
                }else{
                    $('#send_receipt').addClass('hidden');
                    $('#bank_acc_details').addClass('hidden');
                    $('#file_receipt').prop('required',false);
                }
            });
        })
    </script>
</x-layouts.customer-layout>