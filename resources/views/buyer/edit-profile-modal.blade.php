<!-- Account Information Modal -->
<div id="accountInformationModal2" tabindex="-1" aria-hidden="true"
class="max-h-auto fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden antialiased md:inset-0">
<div class="max-h-auto relative max-h-full w-full max-w-lg p-4">
    <!-- Modal content -->
    <div class="relative rounded-lg bg-white shadow dark:bg-gray-800">
        <!-- Modal header -->
        <div
            class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 dark:border-gray-700 md:p-5">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Account Information</h3>
            <button type="button"
                class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-toggle="accountInformationModal2">
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <!-- Modal body -->
        <form class="p-4 md:p-5" action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <!-- Full Name -->
                <div class="col-span-2 sm:col-span-2">
                    <label for="full_name_info_modal"
                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Your Full
                        Name* </label>
                        <input type="text" id="full_name_info_modal" name="name"
                        value="{{ old('name', $user->name) }}"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500"
                        placeholder="Enter your full name" required />
                </div>
                
                <!-- Email -->
                <div class="col-span-2 sm:col-span-2">
                    <label for="email_info_modal"
                        class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Your Email*
                    </label>
                    <input type="email" id="email_info_modal" name="email"
                    value="{{ old('email', $user->email) }}"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500"
                    placeholder="Enter your email here" required />
                </div>
                
                <!-- Phone Number -->
                <div class="col-span-2 sm:col-span-2">
                    <label for="full_name_info_modal" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white"> Phone Number
                    </label>
                    <input type="text" id="phone_number_info_modal" name="phone_number"
                        value="{{ old('phone_number', $user->phone_number) }}"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-orange-500 focus:ring-orange-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-orange-500 dark:focus:ring-orange-500"
                        placeholder="Enter your phone number" />
                </div>
            </div>
            <div class="border-t border-gray-200 pt-4 dark:border-gray-700 md:pt-5">
                <button type="submit"
                    class="me-2 inline-flex items-center rounded-lg bg-orange-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-orange-800 focus:outline-none focus:ring-4 focus:ring-orange-300 dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">Save
                    information</button>
                <button type="button" data-modal-toggle="accountInformationModal2"
                    class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-orange-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">Cancel</button>
            </div>
        </form>
    </div>
</div>
</div>