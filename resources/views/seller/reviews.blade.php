<x-layouts.app :title="__('Reviews')">
    <x-dashboard-header>Reviews</x-dashboard-header>
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
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400  border-gray-200" id="reviews-table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Product</th>
                    <th scope="col" class="px-6 py-3">Customer</th>
                    <th scope="col" class="px-6 py-3">Review</th>
                    <th scope="col" class="px-6 py-3">Comment</th>
                    <th scope="col" class="px-6 py-3">Rating</th>
                    <th scope="col" class="px-6 py-3">Response</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4">{{ $review->product->name }}</td>
                    <td class="px-6 py-4 flex items-center gap-3">
                        <img class="w-5 h-5 rounded-full" src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : 'https://placehold.co/200x200/orange/white?text=' . $review->user->username }}" alt="{{ $review->user->avatar ? "Customer Avatar" : 'Placeholder Avatar' }}" alt="Customer Avatar">
                        <span>{{ $review->user->name }}</span>
                    </td>
                    <td class="px-6 py-4">{{ $review->title }}</td>
                    <td class="px-6 py-4">{{ $review->content }}</td>
                    <td class="px-6 py-4">{{ $review->rating }} / 5</td>
                    <td class="px-6 py-4">{{ $review->response ?? 'No Response' }}</td>
                    <td class="px-6 py-4">{{ $review->created_at->format('Y-m-d') }}</td>
                    <td class="px-6 py-4">
                        <button data-modal-target="response-modal-{{ $review->id }}" data-modal-toggle="response-modal-{{ $review->id }}"
                            class="text-white bg-accent hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-4 py-2">
                            Respond
                        </button>
                    </td>
                </tr>

                <!-- Response Modal -->
                <div id="response-modal-{{ $review->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Respond to Review
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-toggle="response-modal-{{ $review->id }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6 space-y-6">
                                <!-- Display the review text -->
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">Review:</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        "{{ $review->content }}"
                                    </p>
                                </div>
                
                                <!-- Response Form -->
                                <form action="{{ route('seller.reviews.respond', $review->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="response-{{ $review->id }}" class="block text-sm font-medium text-gray-900 dark:text-white">
                                            Your Response
                                        </label>
                                        <textarea id="response-{{ $review->id }}" name="response" rows="4"
                                            class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="Write your response here..." required></textarea>
                                    </div>
                                    <button type="submit"
                                        class="w-full text-white bg-pink-600 hover:bg-pink-700 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                                        Submit Response
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    @push('js')
        <script src="{{ asset('js/reviews-table.js') }}"></script>
    @endpush
</x-layouts.app>
