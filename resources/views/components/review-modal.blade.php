<!-- Add review modal -->
<div id="review-modal" tabindex="-1" aria-hidden="true" data-store-url="{{ route('reviews.store', $product->id) }}"
class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 antialiased">
<div class="relative max-h-full w-full max-w-2xl p-4">
    <!-- Modal content -->
    <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
        <!-- Modal header -->
        <div
            class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
            <div>
                <h3 class="mb-1 text-lg font-semibold text-gray-900 dark:text-white">Add a review for:</h3>
                <a href="#" class="font-medium text-primary-700 hover:underline dark:text-primary-500">
                    {{ $product->name }}</a>
            </div>
            <button type="button"
                class="absolute right-5 top-5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="review-modal">
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <form id="review-form" class="p-4 md:p-5">
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <i data-value="{{ $i }}" class="rating-star ms-2 h-6 w-6 fa-solid fa-star text-gray-300 dark:text-gray-500"></i>
                        @endfor
                        <span id='total_selected_rating' class="ms-2 text-lg font-bold text-gray-900 dark:text-white">0 out of 5</span>
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="title"
                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Review
                        title</label>
                    <input type="text" name="title" id="title"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                        required="" />
                </div>
                <div class="col-span-2">
                    <label for="content"
                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Review
                        content</label>
                    <textarea id="content" rows="6"
                        class="mb-2 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500"
                        required=""></textarea>
                    <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">Problems with the product or
                        delivery? <a href="#"
                            class="text-primary-600 hover:underline dark:text-primary-500">Send a report</a>.
                    </p>
                </div>
                {{-- <div class="col-span-2">
                    <p class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Add real photos of
                        the product to help other customers <span
                            class="text-gray-500 dark:text-gray-400">(Optional)</span></p>
                    <div class="flex w-full items-center justify-center">
                        <label for="dropzone-file"
                            class="dark:hover:bg-bray-800 flex h-52 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pb-6 pt-5">
                                <svg class="mb-4 h-8 w-8 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                    800x400px)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" />
                        </label>
                    </div>
                </div> --}}
                
            </div>
            <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                <button type="submit"
                    class="me-2 inline-flex items-center rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Add
                    review</button>
                <button type="button" data-modal-toggle="review-modal"
                    class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Cancel</button>
            </div>
        </form>
    </div>
</div>
</div>