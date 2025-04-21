$(document).ready(function () {
    // Open the modal
    $('[data-modal-toggle="review-modal"]').on('click', function () {
        $('#review-modal').toggleClass('hidden');
    });

    // Close the modal
    $('.close-modal').on('click', function () {
        $('#review-modal').addClass('hidden');
    });

    // Handle star rating click
    let selectedRating = 0;
    $('.rating-star').on('click', function () {
        selectedRating = $(this).data('value');
        console.log(selectedRating);
        $('.rating-star').each(function () {
            if ($(this).data('value') <= selectedRating) {
                $(this).addClass('text-yellow-300').removeClass('text-gray-300 dark:text-gray-500');
            } else {
                $(this).addClass('text-gray-300 dark:text-gray-500').removeClass('text-yellow-300');
            }
        });

        $('#total_selected_rating').text(selectedRating + '.0 out of 5');
    });
    
    // Get the store URL from the modal's data attribute
    const storeUrl = $('#review-modal').data('store-url');

    // Handle form submission
    $('#review-form').on('submit', function (e) {
        e.preventDefault();

        if (selectedRating === 0) {
            alert('Please select a rating.');
            return;
        }

        const formData = {
            title: $('#title').val(),
            rating: selectedRating,
            content: $('#content').val(),
            _token:  $('meta[name="csrf-token"]').attr('content')
        };
        console.log($('#title').val());
        console.log($('#content').val());
        

        $.ajax({
            url: storeUrl,
            method: 'POST',
            data: formData,
            success: function (response) {
                alert('Review submitted successfully!');
                location.reload(); // Reload the page to show the new review
            },
            error: function (error) {
                alert(error.responseJSON.message || 'An error occurred while submitting the review.');
            }
        });
    });
});