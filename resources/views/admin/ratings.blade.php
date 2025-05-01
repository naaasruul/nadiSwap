<x-layouts.app :title="__('Rating and Reviews')">
    <x-dashboard-header>Rating & Reviews</x-dashboard-header>

    @if (session('success'))
    <div class="p-4 my-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
        role="alert">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="p-4 my-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container mx-auto p-5">
        <h2 class="text-2xl font-bold mb-4">Customer Reviews</h2>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Product</th>
                    <th scope="col" class="px-6 py-3">Customer</th>
                    <th scope="col" class="px-6 py-3">Review</th>
                    <th scope="col" class="px-6 py-3">Comment</th>
                    <th scope="col" class="px-6 py-3">Rating</th>
                    <th scope="col" class="px-6 py-3">Response</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $review->product->name }}</td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <img class="w-5 h-5 rounded-full" src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : '' }}" alt="Customer Avatar">
                        <span>{{ $review->user->name }}</span>
                    </td>
                    <td class="px-6 py-4">{{ $review->title }}</td>
                    <td class="px-6 py-4">{{ $review->content }}</td>
                    <td class="px-6 py-4">{{ $review->rating }} / 5</td>
                    <td class="px-6 py-4">{{ $review->response ?? 'No Response' }}</td>
                    <td class="px-6 py-4">{{ $review->created_at->format('Y-m-d') }}</td>
               
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</x-layouts.app>