<!-- Step 3: Review -->
<div id="review-part" class="content" role="tabpanel">
    <div class="py-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Step 3: Review</h2>

        <p class="text-gray-700 dark:text-gray-300">Preview of all details will be shown here.</p>
        {{-- You can dynamically fill in the values using JS later --}}
        <div id="review-details" class="mt-4">
            <div class="mb-4">
                <h1 id="review-address" class="text-xl font-bold mb-3"></h1>
                <!-- Dynamic carousel -->
                {{-- <div  class="relative w-full">
                    <div id="image-review" class="relative h-56 overflow-hidden rounded-lg md:h-96"></div>
                    <div id="image-indicators"></div>
                </div> --}}
            </div>
            <div class="mb-4"><strong>House Type:</strong> <span id="review-house-type"></span></div>
            <div class="mb-4"><strong>Monthly Rent:</strong> <span id="review-rent"></span></div>
            <div class="mb-4"><strong>Deposit:</strong> <span id="review-deposit"></span></div>
            <div class="mb-4"><strong>Facilities:</strong> <span id="review-facilities"></span></div>
            <div class="mb-4"><strong>Preferred Gender:</strong> <span id="review-gender"></span></div>
            <div class="mb-4"><strong>Other Preferences:</strong> <span id="review-preferences"></span></div>
            <div class="mb-4"><strong>Other Payments:</strong>
                <ul id="review-other-payments" class="list-disc list-inside"></ul>
            </div>
            <div class="mb-4"><strong>Description:</strong> <span id="review-description"></span></div>
            <div class="flex justify-between mt-6">
                <button type="button"
                    class="prev-btn text-gray-900 bg-white border border-gray-300 px-5 py-2.5 rounded dark:bg-gray-800 dark:text-white dark:border-gray-600">Previous</button>
                <button type="button"
                    class="next-btn text-white bg-blue-700 hover:bg-blue-800 px-5 py-2.5 rounded">Next</button>
            </div>
        </div>

    </div>
</div>
