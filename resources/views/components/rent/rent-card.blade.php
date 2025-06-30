{{-- filepath: c:\Users\Nasul\OneDrive\Desktop\project_client\flowbite-app\resources\views\components\rent\rent-card.blade.php --}}
<div
    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
    <a href="#">
        <img class="p-0 rounded-t-lg w-full h-50 object-cover"
            src="{{ asset('storage/' . (json_decode($product->images)[0] ?? 'default.jpg')) }}" alt="House image" />
    </a>
    <div class="px-5 pb-5 pt-4 ">
        <a href="#">
            <h5 class="text-xl truncate font-semibold tracking-tight text-gray-900 dark:text-white mb-1 flex items-center gap-2">
                {{ $product->address }}
            </h5>
        </a>
        <div class="flex items-center text-gray-500 text-sm mb-2 gap-4">
            <span class="flex items-center gap-1">
                <i class="fa-solid fa-house"></i>
                {{ ucfirst($product->house_type) }}
            </span>
            <span class="flex items-center gap-1">
                <i class="fa-solid fa-venus-mars"></i> {{ ucfirst($product->preferred_gender) }}
            </span>
        </div>
        
        <div class="flex items-center justify-between mb-2">
            <span
                class="text-2xl font-bold text-gray-900 dark:text-white">RM{{ number_format($product->rent, 2) }}<span class="text-sm text-gray-500 font-extralight">/month</span> </span>
    
       </div>
        
        <div class="mt-5 flex justify-end">
            <a href="{{ route('rent.details', ['id' => $product->id]) }}"
                class="text-white bg-orange-500 hover:bg-orange-700 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-400 dark:hover:bg-orange-700 dark:focus:ring-orange-800 flex items-center gap-2">
                View Details
            </a>
        </div>
    </div>
</div>
