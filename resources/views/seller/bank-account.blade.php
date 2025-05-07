<x-layouts.app :title="__('List Of Orders')">
    <x-dashboard-header>My Bank Account</x-dashboard-header>
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
        <form action="{{ route('seller.bank-account.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="bank_acc_name" class="block text-sm font-medium text-gray-700">Bank Account Name</label>
                <input type="text" name="bank_acc_name" id="bank_acc_name" value="{{ old('bank_acc_name', $seller->bankAccount->bank_acc_name ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="bank_acc_number" class="block text-sm font-medium text-gray-700">Bank Account Number</label>
                <input type="text" name="bank_acc_number" id="bank_acc_number" value="{{ old('bank_acc_number', $seller->bankAccount->bank_acc_number ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="bank_type" class="block text-sm font-medium text-gray-700">Bank Type</label>
                <input type="text" name="bank_type" id="bank_type" value="{{ old('bank_type', $seller->bankAccount->bank_type ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
            </div>

            <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-lg">Save</button>
        </form>
    </div>
</x-layouts.app>