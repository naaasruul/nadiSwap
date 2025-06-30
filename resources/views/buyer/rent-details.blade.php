<x-layouts.customer-layout>
    {{-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\flowbite-app\resources\views\buyer\rent-details.blade.php --}}
<section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
        <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
            <div class="shrink-0 w-full">
                @php
                    $images = json_decode($product->images ?? '[]');
                @endphp
                @if($images && count($images) > 0)
                    <div id="rent-carousel" class="relative w-full" data-carousel="slide">
                        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                            @foreach($images as $idx => $img)
                                <div class="{{ $idx === 0 ? '' : 'hidden' }} duration-700 ease-in-out" data-carousel-item>
                                    <img src="{{ asset('storage/' . $img) }}" class="block w-full h-full object-cover rounded-lg" alt="House image {{ $idx+1 }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3">
                            @foreach($images as $idx => $img)
                                <button type="button" class="w-3 h-3 rounded-full {{ $idx === 0 ? 'bg-blue-600' : 'bg-gray-300' }}" aria-current="{{ $idx === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $idx+1 }}" data-carousel-slide-to="{{ $idx }}"></button>
                            @endforeach
                        </div>
                        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/></svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" fill="none" viewBox="0 0 6 10"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                @else
                    <img class="w-full rounded-lg" src="{{ asset('storage/' . 'images/default.jpg') }}" alt="No image available" />
                @endif
            </div>

            <div class="mt-6 sm:mt-8 lg:mt-0">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">
                    {{ $product->address }}
                </h1>
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    <span class="flex items-center gap-1 text-gray-700 dark:text-gray-300">
                        <i class="fa-solid fa-house"></i> {{ ucfirst($product->house_type) }}
                    </span>
                    <span class="flex items-center gap-1 text-gray-700 dark:text-gray-300">
                        <i class="fa-solid fa-venus-mars"></i> {{ ucfirst($product->preferred_gender) }}
                    </span>
                    <span class="flex items-center gap-1 text-gray-700 dark:text-gray-300">
                        <i class="fa-solid fa-users"></i> {{ $product->tenant_total ?? '-' }} people needed
                    </span>
                </div>
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-3xl font-extrabold text-blue-700 dark:text-blue-400">RM{{ number_format($product->rent, 2) }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Deposit: RM{{ number_format($product->deposit, 2) }}</span>
                </div>
                @if($product->facilities)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach(explode(',', $product->facilities) as $facility)
                            @if(trim($facility))
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    <i class="fa-solid fa-circle-check mr-1"></i>{{ trim($facility) }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                @endif
                @if($product->other_payments)
                    <div class="mb-4">
                        <span class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Other Payments:</span>
                        <ul class="list-disc list-inside text-xs text-gray-700 dark:text-gray-300">
                            @foreach(json_decode($product->other_payments, true) as $payment)
                                <li>{{ $payment['name'] ?? '' }}: RM{{ $payment['amount'] ?? '' }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if($product->other_preferences)
                    <div class="mb-4">
                        <span class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Preferences:</span>
                        <span class="text-xs text-gray-700 dark:text-gray-300">
                            {{ str_replace(',', ', ', $product->other_preferences) }}
                        </span>
                    </div>
                @endif
                <div class="mb-4">
                    <span class="block text-xs text-gray-500 dark:text-gray-400 mb-1">Description:</span>
                    <span class="text-sm text-gray-700 dark:text-gray-300">
                        {{ $product->description ?? '-' }}
                    </span>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <button
                        id="whatsapp-button"
                        title="Contact Now"
                        class="text-white text-center bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center dark:bg-green-500 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        role="button"
                    >
                        <i class="fa-brands  fa-whatsapp mr-2"></i>
                        Contact Now
                    </buttoi>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
    $(document).ready(function() {
        $('#whatsapp-button').on('click', function() {
            // Replace with the full international phone number (no + or spaces)
            var phoneNumber = "[{{ auth()->user()->phone_number }}]"; // Malaysia: 60 + phone
            var message = "Hi, I'm interested!";
            var url = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(message)}`;

            window.open(url, '_blank'); // Open WhatsApp in new tab
        });
    });
</script>
@endpush
</x-layouts.customer-layout>