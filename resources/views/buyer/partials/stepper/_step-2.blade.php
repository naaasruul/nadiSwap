<!-- Step 2: Preferences -->
<div id="preferences-part" class="content" role="tabpanel">
    <div class="py-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Step 2: Preferences</h2>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preferred Gender</label>
            <select name="preferred_gender"
                id="preferred-gender"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">Select</option>
                <option value="male">Lelaki</option>
                <option value="female">Perempuan</option>
                <option value="any">Tak kisah</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Other Preferences</label>
            <div id="preference-chip-container" class="flex flex-wrap items-center gap-2   rounded-lg "></div>

            <input name="other_preferences" type="text" id="preference-chip-input" placeholder="Non-smoker, student only, no pets..."
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
            <input type="hidden" name="preferences" id="preferences-hidden" />
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
