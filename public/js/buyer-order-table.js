if (document.getElementById("buyer-order-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const table = new simpleDatatables.DataTable("#buyer-order-table", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Search orders...",
            searchTitle: "Search within orders",
            pageTitle: "Page {page}",
            perPage: "orders per page",
            noRows: "No orders found",
            info: "Showing {start} to {end} of {rows} orders",
            noResults: "No results match your search query",
        },
		header: true, // enable or disable the header
		template: (options, dom) => "<div class='" + options.classes.top + " pt-2'>" +
			"<div class='flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse w-full sm:w-auto'>" +
			(options.paging && options.perPageSelect ?
				"<div class='" + options.classes.dropdown + "'>" +
					"<label class='flex items-center space-x-2 whitespace-nowrap'>" +
						"<select class='" + options.classes.selector + "'></select> " + options.labels.perPage +
					"</label>" +
				"</div>" : ""
			) + 
			`</div>` + 
            `<select id="order-status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">All Order Status</option>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select id="delivery-status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">All Delivery Status</option>
                <option value="pending">Pending</option>
                <option value="shipped">Shipped</option>
                <option value="ofd">Out for Delivery</option>
                <option value="delivered">Delivered</option>
            </select>
            <select id="payment-status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">All Payment Status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="failed">Failed</option>
            </select>` + 
			(options.searchable ?
                `<div class=" + ${options.classes.search} + ">` +
                    `<div class="relative">` +
                        `<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>` +
                        "<input class='block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " + options.classes.input +  "' placeholder='" + options.labels.placeholder + "' type='search' title='" + options.labels.searchTitle + "'" + (dom.id ? " aria-controls='" + dom.id + "'" : "") + ">" +
                    "</div>" +
                "</div>" : ""
            ) +
		"</div>" +
		"<div class='" + options.classes.container + "'" + (options.scrollY.length ? " style='height: " + options.scrollY + "; overflow-Y: auto;'" : "") + "></div>" +
		"<div class='" + options.classes.bottom + "'>" +
			(options.paging ?
				"<div class='" + options.classes.info + "'></div>" : ""
			) +
			"<nav class='" + options.classes.pagination + "'></nav>" +
		"</div>"
    });

    // Store original data and current filters
    let originalData = null;
    let currentFilters = {
        payment: '',
        delivery: '',
        order: ''
    };

    // Function to apply URL filters from PHP
    function applyUrlFilters() {
        if (typeof window.urlFilters !== 'undefined') {
            console.log('Applying URL filters:', window.urlFilters);
            
            // Set filter values from URL parameters
            if (window.urlFilters.payment_status) {
                currentFilters.payment = window.urlFilters.payment_status;
                const paymentSelect = document.getElementById('payment-status-filter');
                if (paymentSelect) {
                    paymentSelect.value = window.urlFilters.payment_status;
                }
            }
            
            if (window.urlFilters.delivery_status) {
                currentFilters.delivery = window.urlFilters.delivery_status;
                const deliverySelect = document.getElementById('delivery-status-filter');
                if (deliverySelect) {
                    deliverySelect.value = window.urlFilters.delivery_status;
                }
            }
            
            if (window.urlFilters.order_status) {
                currentFilters.order = window.urlFilters.order_status;
                const orderSelect = document.getElementById('order-status-filter');
                if (orderSelect) {
                    orderSelect.value = window.urlFilters.order_status;
                }
            }
            
            // Apply the filters after setting the dropdown values
            setTimeout(() => {
                applyFilters();
            }, 200);
        }
    }

    // Wait for table to initialize and store original data
    setTimeout(() => {
        originalData = [...table.data.data];
        console.log('Original data stored:', originalData.length, 'rows');
        
        // Apply URL filters after data is ready
        applyUrlFilters();
    }, 100);

    // Helper function to extract text content from cell data
    function getCellText(cellData) {
        if (!cellData) return '';
        
        // If it's a string, return as-is
        if (typeof cellData === 'string') {
            // Remove HTML tags and get clean text
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = cellData;
            return tempDiv.textContent.trim().toLowerCase();
        }
        
        // If it's an array of DOM nodes (which is your case)
        if (Array.isArray(cellData)) {
            // Find the SPAN element (usually at index 1)
            for (let node of cellData) {
                if (node.nodeName === 'SPAN' && node.childNodes && node.childNodes.length > 0) {
                    // Get text from the span's child text node
                    const textNode = node.childNodes[0];
                    if (textNode && textNode.data) {
                        return textNode.data.trim().toLowerCase();
                    }
                }
            }
            // Fallback: concatenate all text content
            return cellData.map(node => {
                if (node.data) return node.data;
                if (node.textContent) return node.textContent;
                return '';
            }).join('').trim().toLowerCase();
        }
        
        // If it's a single HTML element, get text content
        if (cellData && typeof cellData === 'object' && cellData.textContent) {
            return cellData.textContent.trim().toLowerCase();
        }
        
        // Fallback - convert to string and clean
        return String(cellData).toLowerCase();
    }

    // Apply all active filters
    function applyFilters() {
        if (!originalData) {
            console.warn('Original data not available yet');
            return;
        }

        console.log('Applying filters:', currentFilters);
        let filteredData = [...originalData];

        // Apply payment status filter (column 6)
        if (currentFilters.payment !== '') {
            filteredData = filteredData.filter(row => {
                const cellText = getCellText(row.cells[6].data);
                const matches = cellText.includes(currentFilters.payment.toLowerCase());
                return matches;
            });
        }

        // Apply delivery status filter (column 7)
        if (currentFilters.delivery !== '') {
            filteredData = filteredData.filter(row => {
                const cellText = getCellText(row.cells[7].data);
                // Handle special case for "Out for Delivery"
                const searchTerm = currentFilters.delivery.toLowerCase();
                if (searchTerm === 'ofd') {
                    return cellText.includes('out for delivery') || cellText.includes('ofd');
                }
                return cellText.includes(searchTerm);
            });
        }

        // Apply order status filter (column 8)
        if (currentFilters.order !== '') {
            filteredData = filteredData.filter(row => {
                const cellText = getCellText(row.cells[8].data);
                return cellText.includes(currentFilters.order.toLowerCase());
            });
        }

        console.log('Filtered data:', filteredData.length, 'rows');
        
        // Update table with filtered data
        table.data.data = filteredData;
        table.update();
    }

    // Reset filters
    function resetFilters() {
        currentFilters = { payment: '', delivery: '', order: '' };
        
        // Reset dropdown values
        const paymentSelect = document.getElementById('payment-status-filter');
        const deliverySelect = document.getElementById('delivery-status-filter');
        const orderSelect = document.getElementById('order-status-filter');
        
        if (paymentSelect) paymentSelect.value = '';
        if (deliverySelect) deliverySelect.value = '';
        if (orderSelect) orderSelect.value = '';
        
        if (originalData) {
            table.data.data = [...originalData];
            table.update();
        }

        // Update URL to remove filter parameters
        const url = new URL(window.location);
        url.searchParams.delete('payment_status');
        url.searchParams.delete('delivery_status');
        url.searchParams.delete('order_status');
        window.history.replaceState({}, '', url);
    }

    // Function to update URL with current filters
    function updateUrl() {
        const url = new URL(window.location);
        
        if (currentFilters.payment) {
            url.searchParams.set('payment_status', currentFilters.payment);
        } else {
            url.searchParams.delete('payment_status');
        }
        
        if (currentFilters.delivery) {
            url.searchParams.set('delivery_status', currentFilters.delivery);
        } else {
            url.searchParams.delete('delivery_status');
        }
        
        if (currentFilters.order) {
            url.searchParams.set('order_status', currentFilters.order);
        } else {
            url.searchParams.delete('order_status');
        }
        
        window.history.replaceState({}, '', url);
    }

    // Payment Status Filter
    const paymentFilter = document.getElementById('payment-status-filter');
    if (paymentFilter) {
        paymentFilter.addEventListener('change', (e) => {
            currentFilters.payment = e.target.value;
            console.log('Payment filter changed to:', e.target.value);
            
            if (e.target.value === '') {
                // If clearing this filter, check if others are active
                if (!currentFilters.delivery && !currentFilters.order) {
                    resetFilters();
                    return;
                }
            }
            
            applyFilters();
            updateUrl();
        });
    }

    // Delivery Status Filter
    const deliveryFilter = document.getElementById('delivery-status-filter');
    if (deliveryFilter) {
        deliveryFilter.addEventListener('change', (e) => {
            currentFilters.delivery = e.target.value;
            console.log('Delivery filter changed to:', e.target.value);
            
            if (e.target.value === '') {
                // If clearing this filter, check if others are active
                if (!currentFilters.payment && !currentFilters.order) {
                    resetFilters();
                    return;
                }
            }
            
            applyFilters();
            updateUrl();
        });
    }

    // Order Status Filter
    const orderFilter = document.getElementById('order-status-filter');
    if (orderFilter) {
        orderFilter.addEventListener('change', (e) => {
            currentFilters.order = e.target.value;
            console.log('Order filter changed to:', e.target.value);
            
            if (e.target.value === '') {
                // If clearing this filter, check if others are active
                if (!currentFilters.payment && !currentFilters.delivery) {
                    resetFilters();
                    return;
                }
            }
            
            applyFilters();
            updateUrl();
        });
    }

    // Add a manual reset button functionality (optional)
    window.resetOrderFilters = resetFilters;
}