<!-- Single Edit Modal that will be populated dynamically -->
<div id="edit-product-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed top-0 left-0 right-0 z-100 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full modal">
    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Product
                </h3>
                <button type="button" data-modal-toggle="edit-product-modal"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <form id="edit-product-form" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit-name"
                            class="block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="edit-name" name="name"
                            class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="edit-price"
                            class="block text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" id="edit-price" name="price" step="any"
                            class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="edit-stock"
                            class="block text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                        <input type="number" id="edit-stock" name="stock"
                            class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Current Images</label>
                        <div id="edit-existing-images" class="grid grid-cols-3 gap-4 mt-4">
                            <!-- Images will be populated here -->
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="edit-add-images" class="block text-sm font-medium text-gray-900 dark:text-white">Add
                            New Images</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="edit-add-images"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-solid fa-cloud-arrow-up fa-xl mb-4 text-accent-content"></i>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                            class="font-semibold">Click to upload</span></p>
                                </div>
                                <input type="file" id="edit-add-images" name="new_images[]" class="hidden"
                                    accept="image/*" multiple />
                            </label>
                        </div>
                        <div id="edit-image-preview" class="grid grid-cols-3 gap-4 mt-4"></div>
                    </div>

                    <div class="mb-4">
                        <label for="edit-description"
                            class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea id="edit-description" name="description" rows="4"
                            class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-pink-500 focus:border-pink-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                            required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="edit-category_id"
                            class="block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="edit-category_id" name="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-pink-500 focus:border-pink-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-pink-500 dark:focus:border-pink-500"
                            required>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800">
                        Update Product
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Edit product functionality
    document.addEventListener('DOMContentLoaded', function() {
        const editForm = document.getElementById('edit-product-form');
        
        // Function to populate modal with product data
        function populateEditModal(productData) {
            document.getElementById('edit-name').value = productData.name;
            document.getElementById('edit-price').value = productData.price;
            document.getElementById('edit-stock').value = productData.stock;
            document.getElementById('edit-description').value = productData.description;
            document.getElementById('edit-category_id').value = productData.category;
            
            // Set form action
            editForm.action = `/seller/products/${productData.id}`;
            
            // Handle existing images
            const existingImagesContainer = document.getElementById('edit-existing-images');
            existingImagesContainer.innerHTML = '';
            
            if (productData.images) {
                let images;
                try {
                    images = JSON.parse(productData.images);
                } catch (e) {
                    images = [productData.images];
                }
                
                if (Array.isArray(images)) {
                    images.forEach((image, index) => {
                        const imageDiv = document.createElement('div');
                        imageDiv.className = 'relative';
                        imageDiv.innerHTML = `
                            <img src="/storage/${image}" class="w-full h-32 object-cover rounded-lg border">
                            <input type="hidden" name="existing_images[]" value="${image}">
                            <button type="button" onclick="removeExistingImage(this)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">&times;</button>
                        `;
                        existingImagesContainer.appendChild(imageDiv);
                    });
                }
            }
            
            // Clear new image preview
            document.getElementById('edit-image-preview').innerHTML = '';
            document.getElementById('edit-add-images').value = '';
        }
        
        // Event delegation for edit buttons
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-product-btn')) {
                const productData = {
                    id: e.target.dataset.productId,
                    name: e.target.dataset.productName,
                    price: e.target.dataset.productPrice,
                    stock: e.target.dataset.productStock,
                    description: e.target.dataset.productDescription,
                    category: e.target.dataset.productCategory,
                    images: e.target.dataset.productImages
                };
                
                populateEditModal(productData);
            }
        });
        
        // Handle new image upload preview
        document.getElementById('edit-add-images').addEventListener('change', function(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('edit-image-preview');
            previewContainer.innerHTML = '';

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-full', 'h-32', 'object-cover', 'rounded-lg', 'border');
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600';
                    removeBtn.onclick = function(e) {
                        e.preventDefault();
                        wrapper.remove();
                        
                        const dt = new DataTransfer();
                        const input = document.getElementById('edit-add-images');
                        const { files } = input;
                        
                        for(let i = 0; i < files.length; i++) {
                            if(i !== index) dt.items.add(files[i]);
                        }
                        
                        input.files = dt.files;
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });
    });
    
    // Function to remove existing images
    function removeExistingImage(button) {
        button.closest('div').remove();
    }
</script>