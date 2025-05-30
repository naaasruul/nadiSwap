if (document.getElementById("admin-order-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const table = new simpleDatatables.DataTable("#admin-order-table", {
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
		`<select id="payment-status-filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">All Payment Status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="failed">Failed</option>
            </select>` + 
			(options.searchable ?
				`<div class=" + ${options.classes.search} + ">` +
					"<input class='" + options.classes.input + "' placeholder='" + options.labels.placeholder + "' type='search' title='" + options.labels.searchTitle + "'" + (dom.id ? " aria-controls='" + dom.id + "'" : "") + ">" +
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

    // Wait for table to initialize and store original data
    setTimeout(() => {
        originalData = [...table.data.data];
        console.log('Original data stored:', originalData.length, 'rows');
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

        console.log('Filtered data:', filteredData.length, 'rows');
        
        // Update table with filtered data
        table.data.data = filteredData;
        table.update();
    }

    // Reset filters
    function resetFilters() {
        currentFilters = { payment: '', delivery: '', order: '' };
        if (originalData) {
            table.data.data = [...originalData];
            table.update();
        }
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
        });
    }
}