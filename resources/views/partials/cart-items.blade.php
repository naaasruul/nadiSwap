<div id="cart-items">
    @if(empty($cart))
    <div class="flex flex-col items-center justify-center py-8">
      <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
      </svg>
      <p class="text-sm text-gray-500 dark:text-gray-400">Your cart is empty</p>
    </div>
    @else
      @foreach($cart as $id => $item)
      <div class="flex items-center justify-between py-2">
        <div class="flex items-center space-x-3">
          <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-lg object-cover border dark:border-gray-700">
          <div>
            <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</h4>
            <div class="text-sm text-gray-500 dark:text-gray-400">
              <span>RM{{ number_format($item['price'], 2) }}</span>
              <span class="mx-1">×</span>
              <span>{{ $item['quantity'] }}</span>
            </div>
          </div>
        </div>
        <form action="{{ route('cart.remove', $id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="flex items-center text-gray-400 hover:text-red-500 transition-colors hover:cursor-pointer">
            <svg class="w-5 h-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="text-xs">Delete</span>
          </button>
        </form>
      </div>
      @endforeach

      <div class="mt-4 border-t pt-4 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
          <span class="text-base font-medium text-gray-900 dark:text-white">Total</span>
          <span class="text-base font-medium text-gray-900 dark:text-white">
            RM{{ number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)), 2) }}
          </span>
        </div>
        <a href="{{ route('cart.index') }}"
           class="block rounded-lg w-full text-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
           Proceed to Checkout
        </a>
      </div>
    @endif
</div>
