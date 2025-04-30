$(()=>{
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  // Function to display a styled alert
  function showAlert(type, message) {
    const alertHtml = `
        <div class="flex alert items-center p-4 mb-4 text-sm text-${type === 'success' ? 'green' : 'red'}-800 rounded-lg bg-${type === 'success' ? 'green' : 'red'}-50 dark:bg-gray-800 dark:text-${type}-400" role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 1 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">${type === 'success' ? 'Sucessful!' : 'Error alert!'}</span> ${message}
            </div>
        </div>
    `;

    // Append the alert to the body or a specific container
    $('.alert-message').append(alertHtml);

    // Automatically remove the alert after 5 seconds
    setTimeout(() => {
        $('.alert-message').find('.alert').remove();
    }, 2000);
}
    $('.payment-status-dropdown').on('change', function () {
        const orderId = $(this).data('id');
        const newStatus = $(this).val();

        console.log(orderId); // Debugging line
        console.log(newStatus); // Debugging line
        $.ajax({
            url: `/seller/orders/${orderId}/update-payment-status`,
            method: 'POST',

            data: {
                payment_status: newStatus
            },
            success: function (response) {
                console.log(response); // Debugging line
                showAlert('success', 'Payment status updated successfully!');
            },
            error: function (xhr) {
                alert('Failed to update payment status.');
                console.error(xhr.responseText);
            }
        });
    });

    // Handle Delivery Status Change
    $('.delivery-status-dropdown').on('change', function () {
        const orderId = $(this).data('id');
        const newStatus = $(this).val();

        $.ajax({
            url: `/seller/orders/${orderId}/update-delivery-status`,
            method: 'POST',
            data: {
                delivery_status: newStatus
            },
            success: function (response) {
                showAlert('success', 'Delivery status updated successfully!');
            },
            error: function (xhr) {
                showAlert('red', 'Failed to update delivery status.');
                console.error(xhr.responseText);
            }
        });
    });
})