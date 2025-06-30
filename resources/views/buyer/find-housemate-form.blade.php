<x-layouts.customer-layout>


    <section class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-10 mx-auto max-w-screen-xl px-4 2xl:px-0">

        <div class="max-w-4xl mx-auto">
            <x-dashboard-header>Find Housemate 🏠</x-dashboard-header>
            <div class="bs-stepper bg-white p-3 rounded-lg "> <!-- add .vertical kalau nak straight -->
                @include('buyer.partials.stepper._stepper-header')

                @include('buyer.partials.stepper._stepper-content')
            </div>
        </div>
    </section>

    @push('scripts')
        <script type="module"
            src="https://ajax.googleapis.com/ajax/libs/@googlemaps/extended-component-library/0.6.11/index.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
        <script>
            $(()=>{
                $('#post_find_housemate').on('click', function(e) {
                e.preventDefault();
                alert('Submitting your housemate post...');
                console.log('Form submitting');

                var formData = new FormData();

                formData.append('address', $('#selected-address').val());
                formData.append('house_type', $('#house-type').val());
                formData.append('rent', $('#rent').val());
                formData.append('deposit', $('#deposit').val());
                formData.append('facilities', $('#facilities-hidden').val());
                formData.append('preferred_gender', $('#preferred-gender').val());
                formData.append('other_preferences', $('#preferences-hidden').val());

                // Images
                var files = $('#house-images')[0].files;
                for (let i = 0; i < files.length; i++) {
                    formData.append('house_images[]', files[i]);
                }

                // Other payments
                $('#other-payments-list .payment-row').each(function(index) {
                    var name = $(this).find('input[name^="other_payments"][name$="[name]"]').val();
                    var amount = $(this).find('input[name^="other_payments"][name$="[amount]"]').val();
                    if (name && amount) {
                        formData.append(`other_payments[${index}][name]`, name);
                        formData.append(`other_payments[${index}][amount]`, amount);
                    }
                });

                $.ajax({
                    url: '{{ route('rent.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Success! Your housemate post has been created.');
                        // Optionally redirect or reset form
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON?.message || 'Submission failed.'));
                    }
                });
                console.log('Form submitted');
            });
            })
            $(document).ready(function() {
                var stepper = new Stepper($('.bs-stepper')[0],{
                    linear: false,
                    animation: true
                });

                // Facilities chips
                const chipContainer = $('#chip-container');
                const chipInput = $('#chip-input');
                const hiddenInput = $('#facilities-hidden');
                let chips = [];

                const placePicker = document.getElementById('placePicker');
                const addressInput = document.getElementById('selected-address');

                let paymentIndex = 0;
                $('#add-payment-btn').on('click', function() {
                    $('#other-payments-list').append(`
                        <div class="flex items-center justify-center gap-2 mb-2 payment-row">
                            <input type="text" name="other_payments[${paymentIndex}][name]" placeholder="e.g. Utilities" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                            <input type="number" name="other_payments[${paymentIndex}][amount]" placeholder="RM" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                            <button type="button" class="remove-payment-btn text-red-600 text-lg px-2">&times;</button>
                        </div>
                    `);
                    paymentIndex++;
                });

                $('#other-payments-list').on('click', '.remove-payment-btn', function() {
                    $(this).closest('.payment-row').remove();
                });

                function renderChips() {
                    chipContainer.find('.chip').remove();
                    chips.forEach((chip, index) => {
                        const chipEl = $(`
                    <span id="badge-id-${index}" class="chip mb-2 inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-blue-800 bg-blue-100 rounded-sm dark:bg-blue-900 dark:text-blue-300">
                        ${chip}
                        <button type="button" class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-xs hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300" data-index="${index}">&times;</button>
                    </span>
                    `);
                        chipContainer.append(chipEl);
                    });
                    hiddenInput.val(chips.join(','));
                }

                chipInput.on('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        const value = chipInput.val().trim().replace(',', '');
                        if (value && !chips.includes(value)) {
                            chips.push(value);
                            chipInput.val('');
                            renderChips();
                        }
                    }
                });

                chipContainer.on('click', 'button[data-index]', function() {
                    const index = $(this).data('index');
                    chips.splice(index, 1);
                    renderChips();
                });

                // Preferences chips
                const prefer_chipContainer = $('#preference-chip-container');
                const prefer_chipInput = $('#preference-chip-input');
                const prefer_hiddenInput = $('#preferences-hidden');
                let prefer_chips = [];

                function renderPreferChips() {
                    prefer_chipContainer.find('.chip').remove();
                    prefer_chips.forEach((chip, index) => {
                        const chipEl = $(`
                    <span id="prefer-badge-id-${index}" class="chip mb-2 inline-flex items-center px-2 py-1 me-2 text-sm font-medium text-blue-800 bg-blue-100 rounded-sm dark:bg-blue-900 dark:text-blue-300">
                        ${chip}
                        <button type="button" class="inline-flex items-center p-1 ms-2 text-sm text-blue-400 bg-transparent rounded-xs hover:bg-blue-200 hover:text-blue-900 dark:hover:bg-blue-800 dark:hover:text-blue-300" data-index="${index}">&times;</button>
                    </span>
                    `);
                        prefer_chipContainer.append(chipEl);
                    });
                    prefer_hiddenInput.val(prefer_chips.join(','));
                }

                prefer_chipInput.on('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ',') {
                        e.preventDefault();
                        const value = prefer_chipInput.val().trim().replace(',', '');
                        if (value && !prefer_chips.includes(value)) {
                            prefer_chips.push(value);
                            prefer_chipInput.val('');
                            renderPreferChips();
                        }
                    }
                });

                prefer_chipContainer.on('click', 'button[data-index]', function() {
                    const index = $(this).data('index');
                    prefer_chips.splice(index, 1);
                    renderPreferChips();
                });

                // Listen for place changes
                placePicker.addEventListener('gmpx-placechange', (event) => {
                    addressInput.value = placePicker.value.displayName;
                });

                $('.next-btn').click(function() {
                    var address = $('#selected-address').val();
                    var house_type = $('#house-type').val();
                    var rent = $('#rent').val();
                    var deposit = $('#deposit').val();
                    var facilities = $('#facilities-hidden').val();
                    var preferred_gender = $('#preferred-gender').val();
                    var other_preferences = $('#preferences-hidden').val();

                    // Get images
                    var images = [];
                    var files = $('#house-images')[0].files;
                    for (let i = 0; i < files.length; i++) {
                        images.push(files[i].name); // or files[i] for the File object
                    }

                    // Get other payments
                    var other_payments = [];
                    $('#other-payments-list .payment-row').each(function() {
                        var name = $(this).find('input[name^="other_payments"][name$="[name]"]').val();
                        var amount = $(this).find('input[name^="other_payments"][name$="[amount]"]')
                            .val();
                        if (name && amount) {
                            other_payments.push({
                                name,
                                amount
                            });
                        }
                    });

                    console.log({
                        address,
                        house_type,
                        rent,
                        deposit,
                        facilities: facilities ? facilities.split(',') : [],
                        preferred_gender,
                        other_preferences: other_preferences ? other_preferences.split(',') : [],
                        images,
                        other_payments
                    });

                    stepper.next();
                });

                $('.prev-btn').click(function() {
                    stepper.previous();
                });

                const $uploadArea = $('#image-upload-area');
                const $fileInput = $('#house-images');
                const $preview = $('#image-preview');

                // Click on label triggers file input (already works by default)
                // Drag & drop support
                $uploadArea.on('dragover', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $uploadArea.find('label').addClass('border-blue-500');
                });

                $uploadArea.on('dragleave drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    $uploadArea.find('label').removeClass('border-blue-500');
                });

                $uploadArea.on('drop', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let files = e.originalEvent.dataTransfer.files;
                    $fileInput[0].files = files;
                    previewImages(files);
                });

                $fileInput.on('change', function() {
                    previewImages(this.files);
                });

                function previewImages(files) {
                    $preview.html('');
                    Array.from(files).forEach(file => {
                        if (!file.type.startsWith('image/')) return;
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $preview.append(`<div class="">
                    <img src="${e.target.result}" class="w-full h-50 object-cover rounded border" />
                    </div>`);
                        }
                        reader.readAsDataURL(file);
                    });
                }
            });

            
        </script>
    @endpush
</x-layouts.customer-layout>
