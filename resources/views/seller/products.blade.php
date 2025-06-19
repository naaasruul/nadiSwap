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

        <div class="space-y-6">
            <!-- Unsold Products Table -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Unsold Products</h3>
                <table id="unsold-product-table" class="relative z-0">
                    <thead>
                        <tr>
                            <th>
                                <span class="flex items-center">
                                    Image
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
                                    Edit
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    Delete
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    View Product
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unsoldProducts as $product)
                        <tr data-id="{{ $product->id }}" class="product-row">
                            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($product->images)
                                    @php
                                        $images = json_decode($product->images, true); // Decode the JSON string
                                    @endphp
                                    @if (!empty($images) && isset($images[0]))
                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}"
                                            class="w-16 h-16 object-cover rounded">
                                    @else
                                        <span class="text-gray-500">No Image</span>
                                    @endif
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $product->name }}</td>
                            <td> {{ $product->category->name ?? 'Unavalaible'}} </td>
                            <td> RM{{ $product->price }}</td>
                            <td> {{ $product->description }}</td>
                            <td> {{ $product->reviews->avg('rating') ? $product->reviews->avg('rating') : 'No reviews yet' }}
                            </td>
                            <td> {{ $product->reviews->count() }}</td>
                            <td>
                                <!-- Edit Button with data attributes and modal toggle -->
                                <button class="btn edit-product-btn" 
                                        data-modal-target="edit-product-modal"
                                        data-modal-toggle="edit-product-modal"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->price }}"
                                        data-product-stock="{{ $product->stock }}"
                                        data-product-description="{{ $product->description }}"
                                        data-product-category="{{ $product->category_id }}"
                                        data-product-images="{{ $product->images }}">
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
                </table>
            </div>

            <!-- Sold Products Table -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Products With Sales</h3>
                <table id="sold-product-table" class="relative z-0">
                    <thead>
                        <tr>
                            <th>
                                <span class="flex items-center">
                                    Image
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
                                    Total Sold
                                    <i class="fa-solid fa-sort ms-3"></i>
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    View Product
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($soldProducts as $product)
                        <tr data-id="{{ $product->id }}" class="product-row">
                            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                @if ($product->images)
                                    @php
                                        $images = json_decode($product->images, true); // Decode the JSON string
                                    @endphp
                                    @if (!empty($images) && isset($images[0]))
                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}"
                                            class="w-16 h-16 object-cover rounded">
                                    @else
                                        <span class="text-gray-500">No Image</span>
                                    @endif
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white"> {{ $product->name }}</td>
                            <td> {{ $product->category->name ?? 'Unavalaible'}} </td>
                            <td> RM{{ $product->price }}</td>
                            <td> {{ $product->description }}</td>
                            <td> {{ $product->reviews->avg('rating') ? $product->reviews->avg('rating') : 'No reviews yet' }}
                            </td>
                            <td> {{ $product->reviews->count() }}</td>
                            <td> {{ $product->total_sold }}</td>
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
            </div>
        </div>

        @include('Modal.create-product')
        @include('Modal.edit-product')
    </div>

    @push('js')
        <script src="{{ asset('js/sold-product-table.js') }}"></script>
        <script src="{{ asset('js/unsold-product-table.js') }}"></script>
    @endpush
</x-layouts.app>