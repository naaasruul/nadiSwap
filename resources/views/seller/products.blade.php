<x-layouts.app :title="__('My Products')">
    <div class="container">
        <x-dashboard-header>My Products</x-dashboard-header>
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

        <!-- Add Product Modal Toggle -->
        <div class="w-full flex justify-end mb-4">

        </div>

        {{-- <table id="product-filter-table">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            Image
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Product Name
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Category
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Price
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Description
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Rating
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Total Reviews
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>

                    <th>
                        <span class="flex items-center">
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-16 h-16 object-cover rounded">
                        @else
                        <span class="text-gray-500">No Image</span>
                        @endif
                    </td>
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $product->name }}</td>
                    <td> {{ $product->category }}</td>
                    <td> RM{{ $product->price }}</td>
                    <td> {{ $product->description }}</td>
                    <td> {{ $product->reviews->avg('rating') ? $product->reviews->avg('rating') : 'No reviews yet' }}
                    </td>
                    <td> {{ $product->reviews->count() }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button data-modal-target="edit-modal-{{ $product->id }}"
                            data-modal-toggle="edit-modal-{{ $product->id }}" class="btn">
                            Edit
                        </button>
                    </td>
                    <td>
                        <!-- Delete Form -->
                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn">
                                Delete
                            </button>
                        </form>
                    </td>
                    <td>
                        <!-- View Reviews Button -->
                        <a href="{{ route('products.show', $product->id) }}"
                            class="btn text-pink-500 hover:text-pink-700">
                            View Product
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table> --}}

        <table id="export-table" class="relative z-0">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            Image
                            {{-- <i class="fa-solid fa-sort ms-3"></i> --}}
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Product Name
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Category
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Price
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Description
                            <i class="fa-solid fa-sort ms-3"></i>

                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Rating
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            Total Reviews
                            <i class="fa-solid fa-sort ms-3"></i>
                        </span>
                    </th>

                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr data-id="{{ $product->id }}" class="product-row">
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-16 h-16 object-cover rounded">
                        @else
                        <span class="text-gray-500">No Image</span>
                        @endif
                    </td>
                    <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $product->name }}</td>
                    <td> {{ $product->category }}</td>
                    <td> RM{{ $product->price }}</td>
                    <td> {{ $product->description }}</td>
                    <td> {{ $product->reviews->avg('rating') ? $product->reviews->avg('rating') : 'No reviews yet' }}
                    </td>
                    <td> {{ $product->reviews->count() }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button data-modal-target="edit-modal-{{ $product->id }}"
                            data-modal-toggle="edit-modal-{{ $product->id }}" class="btn">
                            Edit
                        </button>
                        @push('modal')
                        @include('Modal.edit-product')
                        @endpush

                    </td>
                    <td>
                        <!-- Delete Form -->
                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn">
                                Delete
                            </button>
                        </form>
                    </td>
                    <td>
                        <!-- View Reviews Button -->
                        <a href="{{ route('products.show', $product->id) }}"
                            class="btn text-pink-500 hover:text-pink-700">
                            View Product
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>



        <!-- Main modal -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add New Product
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="name"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" id="name" name="name"
                                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Product Name" required>
                            </div>
                            <div class="mb-4">
                                <label for="price"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                <input type="number" id="price" name="price"
                                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Product Price" required>
                            </div>
                            <div class="mb-4">
                                <label for="stock"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                                <input type="number" id="stock" name="stock"
                                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Product Price" required>
                            </div>

                            <div class="mb-4">
                                <label for="add-image"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Image</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="add-image"
                                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fa-solid fa-cloud-arrow-up fa-xl mb-4 text-accent-content"></i>

                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                                    class="font-semibold">Click to upload</span>
                                            </p>
                                        </div>
                                        <input type="file" id="add-image" name="image" class="hidden"
                                            accept="image/*" />
                                    </label>
                                </div>

                            </div>
                            <div class="mb-4">
                                <label for="description"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="description" name="description" rows="4"
                                    class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Product Description"></textarea>
                            </div>
                            <div class="mb-4">

                                <label for="category"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select id="category" name="category"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <button type="submit"
                                class="w-full text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                                Save Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-layouts.app>