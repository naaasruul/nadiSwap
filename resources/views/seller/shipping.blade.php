<x-layouts.app :title="__('Shippings')">
    <x-dashboard-header>Shippings</x-dashboard-header>
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

    <!-- Add Shipping Modal Toggle -->
    <div class="w-full flex justify-end mb-4">
        <button data-modal-target="create-shipping" data-modal-toggle="create-shipping"
            class="block text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800"
            type="button">
            Add Shipping
        </button>
    </div>

    <div class="container">
        <table id="search-table">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            Location Name
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Price
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                        </span>
                    </th>
                
                </tr>
            </thead>
            <tbody>
                @foreach ($shippings as $shipping)
                <tr>
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $shipping->place }}</td>
                    <td>RM{{ $shipping->shipping_fee }}</td>
                    <td> 
                        <button data-modal-target="edit-modal-{{ $shipping->id }}"
                            data-modal-toggle="edit-modal-{{ $shipping->id }}" class="btn btn-sm btn-warning">Edit</button>
                    </td>
                    @push('modal')
                        @include('Modal.edit-shipping')
                    @endpush
<td>
                    <form method="POST" action="{{ route('seller.shippings.destroy',$shipping->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger delete-shipping"
                        data-id="{{ $shipping->id }}">Delete
                        </button>
                    </form>
                    </td>
                
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('Modal.add-shipping')
</x-layouts.app>