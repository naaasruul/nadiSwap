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

    {{-- Bank Account Card --}}
    <div class="max-w-md mb-6">
        <div class="rounded-lg shadow bg-white dark:bg-gray-800 p-6">
            <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Current Bank Account</h3>
            @if($seller->bankAccount)
                <p class="text-base text-gray-700 dark:text-gray-200"><span class="font-bold">Account Name:</span> {{ $seller->bankAccount->bank_acc_name ?? 'Unknown' }}</p>
                <p class="text-base text-gray-700 dark:text-gray-200"><span class="font-bold">Account Number:</span> {{ $seller->bankAccount->bank_acc_number ?? 'Unknown' }}</p>
                <p class="text-base text-gray-700 dark:text-gray-200"><span class="font-bold">Bank Type:</span> {{ $seller->bankAccount->bank_type ?? 'Unknown' }}</p>
            @else
                <p class="text-base text-red-600">No bank account setup yet.</p>
            @endif
        </div>
    </div>
    
    <div class="container mx-auto p-5">
        <form action="{{ route('seller.bank-account.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="bank_acc_name" class="block text-sm font-medium text-gray-700">Bank Account Holder Name</label>
                <input type="text" name="bank_acc_name" id="bank_acc_name" value="{{ old('bank_acc_name', $seller->bankAccount->bank_acc_name ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm" placeholder="John Doe">
            </div>

            <div class="mb-4">
                <label for="bank_acc_number" class="block text-sm font-medium text-gray-700">Bank Account Number</label>
                <input type="text" name="bank_acc_number" id="bank_acc_number" value="{{ old('bank_acc_number', $seller->bankAccount->bank_acc_number ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm" placeholder="xxxxxxxxxxx">
            </div>

            <div class="mb-4">
                <label for="bank_type" class="block text-sm font-medium text-gray-700">Bank Type</label>
                {{-- <input type="text" name="bank_type" id="bank_type" value="{{ old('bank_type', $seller->bankAccount->bank_type ?? '') }}"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"> --}}

                <select name="bank_type" id="bank_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                    <option value="" selected disabled>Select Bank</option>
                    <option value="Maybank" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Maybank') ? 'selected' : '' }}>Maybank</option>
                    <option value="CIMB Bank" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'CIMB Bank') ? 'selected' : '' }}>CIMB Bank</option>
                    <option value="Public Bank" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Public Bank') ? 'selected' : '' }}>Public Bank</option>
                    <option value="RHB Bank" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'RHB Bank') ? 'selected' : '' }}>RHB Bank</option>
                    <option value="Ambank" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Ambank') ? 'selected' : '' }}>Ambank</option>
                    <option value="Bank Simpanan Nasional" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Bank Simpanan Nasional') ? 'selected' : '' }}>Bank Simpanan Nasional</option>
                    <option value="Bank Rakyat" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Bank Rakyat') ? 'selected' : '' }}>Bank Rakyat</option>
                    <option value="UOB" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'UOB') ? 'selected' : '' }}>UOB</option>
                    <option value="Affin Bank" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Affin Bank') ? 'selected' : '' }}>Affin Bank</option>
                    <option value="Bank Islam" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Bank Islam') ? 'selected' : '' }}>Bank Islam</option>
                    <option value="HSBC Online" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'HSBC Online') ? 'selected' : '' }}>HSBC Online</option>
                    <option value="Standard Chartered Bank" {{ (old('bank_type', $seller->bankAccount->bank_type ?? '') == 'Standard Chartered Bank') ? 'selected' : '' }}>Standard Chartered Bank</option>
                </select>
            </div>

            <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-lg">Save</button>
        </form>
    </div>
</x-layouts.app>