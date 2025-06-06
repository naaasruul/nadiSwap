// Categories Table with Simple DataTables
if (document.getElementById("categories-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    
    // Custom CSV export function with separator rows
    const exportCustomCSV = function(dataTable, userOptions = {}) {
        const clonedUserOptions = { ...userOptions };
        clonedUserOptions.download = false;
        const csv = simpleDatatables.exportCSV(dataTable, clonedUserOptions);
        
        if (!csv) {
            return false;
        }
        
        const defaults = {
            download: true,
            lineDelimiter: "\n",
            columnDelimiter: ";"
        };
        
        const options = { ...defaults, ...clonedUserOptions };
        
        // Create separator row with "+" characters
        const separatorRow = Array(dataTable.data.headings.filter((_heading, index) => 
            !dataTable.columns.settings[index]?.hidden).length)
            .fill("+")
            .join("+");
        
        const str = separatorRow + options.lineDelimiter + csv + options.lineDelimiter + separatorRow;
        
        if (options.download) {
            const link = document.createElement("a");
            link.href = encodeURI("data:text/csv;charset=utf-8," + str);
            link.download = (options.filename || "categories_export") + ".txt";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        return str;
    };

    // Initialize DataTable
    const table = new simpleDatatables.DataTable("#categories-table", {
        labels: {
            placeholder: "Search categories...",
            searchTitle: "Search within categories",
            pageTitle: "Page {page}",
            perPage: "categories per page",
            noRows: "No categories found",
            info: "Showing {start} to {end} of {rows} categories",
            noResults: "No categories match your search query",
        },
        columns: [
            { 
                select: 0, 
                sort: true,
                searchable: true,
                type: "text"
            },
            { 
                select: 1, 
                sort: false,
                searchable: false,
                type: "html"
            }
        ],
        searchable: true,
        sortable: true,
        paging: true,
        perPage: 10,
        template: (options, dom) => {
            return `
                <div class="${options.classes.top}">`+
					"<div class='flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse w-full sm:w-auto'>" +
					(options.paging && options.perPageSelect ?
						"<div class='" + options.classes.dropdown + "'>" +
							"<label class='flex items-center space-x-2 whitespace-nowrap'>" +
								"<select class='" + options.classes.selector + "'></select> " + options.labels.perPage +
							"</label>" +
						"</div>" : ""
					) + 
					`</div>` +
                    `<div class="flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse w-full sm:w-auto mb-4">` +
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
						`<div class="w-full flex justify-end">
							<button data-modal-target="create-category" data-modal-toggle="create-category"
								class="block text-white bg-pink-700 hover:bg-pink-800 focus:ring-4 focus:outline-none focus:ring-pink-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800"
								type="button">
								Add Category
							</button>
						</div>
                    </div>
                </div>
                <div class="${options.classes.container}"></div>
                <div class="${options.classes.bottom}">
				${options.paging ? `<div class="${options.classes.info}"></div>` : ""}
                    <nav class="${options.classes.pagination}"></nav>
                </div>
            `;
        }
    });

    // Initialize dropdown after table is ready
    table.on("datatable.init", () => {
        console.log("Categories DataTable initialized");
        
        // Add custom styling to the table
        const tableElement = document.querySelector("#categories-table");
        if (tableElement) {
            tableElement.classList.add("w-full", "text-sm", "text-left", "text-gray-500", "dark:text-gray-400");
            
            // Style the thead
            const thead = tableElement.querySelector("thead");
            if (thead) {
                thead.classList.add("text-xs", "text-gray-700", "uppercase", "bg-gray-50", "dark:bg-gray-700", "dark:text-gray-400");
            }

            // Style the tbody rows
            const tbody = tableElement.querySelector("tbody");
            if (tbody) {
                const rows = tbody.querySelectorAll("tr");
                rows.forEach(row => {
                    row.classList.add("bg-white", "border-b", "dark:bg-gray-800", "dark:border-gray-700", "hover:bg-gray-50", "dark:hover:bg-gray-600");
                });
            }

            // Style table cells
            const cells = tableElement.querySelectorAll("td, th");
            cells.forEach(cell => {
                cell.classList.add("px-6", "py-4");
            });
        }
    });

    // Handle table refresh events (useful for dynamic updates)
    table.on("datatable.refresh", () => {
        console.log("Categories DataTable refreshed");
        setTimeout(() => {
            initializeDropdown();
        }, 100);
    });

    // Global function to refresh the table (can be called from other scripts)
    window.refreshCategoriesTable = () => {
        if (table) {
            table.refresh();
        }
    };

    console.log("Categories DataTable script loaded successfully");
}