<style>
    gmpx-place-picker {
        width: 100%;
    }
</style>
<!-- Step 1: House Info -->
<div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
    <div class="py-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Step 1: House Info</h2>

        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-2">
                <label for="house-type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address /
                    Place</label>
                <gmpx-api-loader key="AIzaSyDlVDvZxo_TzeEnJYGowV2HTG6iVDoK-wk" solution-channel="GMP_GE_placepicker_v2">
                </gmpx-api-loader>
                <div id="place-picker-box">
                    <div id="place-picker-container">
                        <gmpx-place-picker id="placePicker" placeholder="Enter an address"></gmpx-place-picker>
                    </div>
                    <input type="text" id="selected-address" name="selected_address"
                        class="" value=""/>
                </div>
                {{-- <gmpx-place-overview id="place-overview"></gmpx-place-overview> --}}

            </div>

            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">House Photos</label>
                <div id="image-upload-area" class="flex items-center justify-center w-full">
                    <label for="house-images"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 ">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                    to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)
                            </p>
                        </div>
                        <input id="house-images" name="house_images[]" type="file" class="hidden" multiple
                            accept="image/*" />
                    </label>
                </div>
                <div id="image-preview" class="grid grid-cols-3 gap-4 mt-3"></div>
            </div>

            <div class="sm:col-span-2">
                <label for="house-type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">House
                    Type</label>
                <select id="house-type" name="house_type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <option value="">Select type</option>
                    <option value="terrace">Terrace</option>
                    <option value="apartment">Apartment</option>
                    <option value="room">Room Only</option>
                </select>
            </div>

            {{-- <div class="sm:col-span-2">
                <label for="location"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                <input type="text" name="location" id="location" placeholder="Seksyen 7, Shah Alam"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div> --}}

            <div>
                <label for="rent" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Monthly Rent
                    (RM)</label>
                <input type="number" name="rent" id="rent" placeholder="300"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>
            <div>
                <label for="deposit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deposit
                    (RM) (Optional)</label>
                <input type="number" name="rent" id="deposit" placeholder="300"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            </div>

            {{-- can add if there's other payment needed. a button "add" that will append 2 input field where it required name of the field and the price. for example, Utilities, RM100 --}}
            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Other Payments
                    (Optional)</label>
                <div id="other-payments-list" class='w-full'></div>
                <button type="button" id="add-payment-btn"
                    class="mt-2 p-2 px-3 text-end bg-purple-600 dark:text-white text-white rounded text-sm">Add
                    Payment</button>
            </div>
            <div class="sm:col-span-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Facilities /
                    Features</label>
                <div id="chip-container" class="flex flex-wrap items-center gap-2   rounded-lg ">

                </div>
                <input type="text" id="chip-input" placeholder="e.g. WiFi, washing machine"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                <input type="hidden" name="facilities" id="facilities-hidden" />
            </div>
        </div>

        <div class="flex justify-between mt-6">
            <button type="button"
                class="prev-btn text-gray-900 bg-white border border-gray-300 px-5 py-2.5 rounded dark:bg-gray-800 dark:text-white dark:border-gray-600">
                Previous
            </button>
            <button type="button" class="next-btn text-white bg-blue-700 hover:bg-blue-800 px-5 py-2.5 rounded">
                Next
            </button>
        </div>
    </div>
</div>

