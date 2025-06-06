if (document.getElementById("sold-product-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const exportCustomCSV = function (dataTable, userOptions = {}) {
        // A modified CSV export that includes a row of minuses at the start and end.
        const clonedUserOptions = {
            ...userOptions
        }
        clonedUserOptions.download = false
        const csv = simpleDatatables.exportCSV(dataTable, clonedUserOptions)
        // If CSV didn't work, exit.
        if (!csv) {
            return false
        }
        const defaults = {
            download: true,
            lineDelimiter: "\n",
            columnDelimiter: ";"
        }
        const options = {
            ...defaults,
            ...clonedUserOptions
        }
        const separatorRow = Array(dataTable.data.headings.filter((_heading, index) => !dataTable.columns.settings[index]?.hidden).length)
            .fill("+")
            .join("+"); // Use "+" as the delimiter

        const str = separatorRow + options.lineDelimiter + csv + options.lineDelimiter + separatorRow;

        if (userOptions.download) {
            // Create a link to trigger the download
            const link = document.createElement("a");
            link.href = encodeURI("data:text/csv;charset=utf-8," + str);
            link.download = (options.filename || "datatable_export") + ".txt";
            // Append the link
            document.body.appendChild(link);
            // Trigger the download
            link.click();
            // Remove the link
            document.body.removeChild(link);
        }

        return str
    }
    
    const table = new simpleDatatables.DataTable("#sold-product-table", {
        labels: {
            placeholder: "Search...",
            searchTitle: "Search within table",
            pageTitle: "Page {page}",
            perPage: "entries per page",
            noRows: "No entries found",
            info: "Showing {start} to {end} of {rows} entries",
            noResults: "No results match your search query",
        },
        header: true,
        template: (options, dom) => "<div class='" + options.classes.top + "'>" +
            "<div class='flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse w-full sm:w-auto'>" +
            `
                <button id='exportDropdownButton' type='button' class='flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto'>
                    Export as   
                    <svg class='-me-0.5 ms-1.5 h-4 w-4' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='none' viewBox='0 0 24 24'>
                        <path stroke='currentColor' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m19 9-7 7-7-7' />
                    </svg>
                </button>

                <div id='exportDropdown' class='z-10 hidden w-52 divide-y divide-gray-100 rounded-lg bg-white shadow-sm dark:bg-gray-700' data-popper-placement='bottom'>
                    <ul class='p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400' aria-labelledby='exportDropdownButton'>
                        <li>
                            <button id='export-csv' class='group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white'>
                                <svg class='me-1.5 h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' viewBox='0 0 24 24'>
                                    <path fill-rule='evenodd' d='M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm1.018 8.828a2.34 2.34 0 0 0-2.373 2.13v.008a2.32 2.32 0 0 0 2.06 2.497l.535.059a.993.993 0 0 0 .136.006.272.272 0 0 1 .263.367l-.008.02a.377.377 0 0 1-.018.044.49.49 0 0 1-.078.02 1.689 1.689 0 0 1-.297.021h-1.13a1 1 0 1 0 0 2h1.13c.417 0 .892-.05 1.324-.279.47-.248.78-.648.953-1.134a2.272 2.272 0 0 0-2.115-3.06l-.478-.052a.32.32 0 0 1-.285-.341.34.34 0 0 1 .344-.306l.94.02a1 1 0 1 0 .043-2l-.943-.02h-.003Zm7.933 1.482a1 1 0 1 0-1.902-.62l-.57 1.747-.522-1.726a1 1 0 0 0-1.914.578l1.443 4.773a1 1 0 0 0 1.908.021l1.557-4.773Zm-13.762.88a.647.647 0 0 1 .458-.19h1.018a1 1 0 1 0 0-2H6.647A2.647 2.647 0 0 0 4 13.647v1.706A2.647 2.647 0 0 0 6.647 18h1.018a1 1 0 1 0 0-2H6.647A.647.647 0 0 1 6 15.353v-1.706c0-.172.068-.336.19-.457Z' clip-rule='evenodd'/>
                                </svg>
                                <span>Export CSV</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            ` +
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
    })
    
    const $exportButton = document.getElementById("exportDropdownButton");
    const $exportDropdownEl = document.getElementById("exportDropdown");
    const dropdown = new Dropdown($exportDropdownEl, $exportButton);
    console.log(dropdown)

    document.getElementById("export-csv").addEventListener("click", () => {
        simpleDatatables.exportCSV(table, {
            download: true,
            lineDelimiter: "\n",
            columnDelimiter: ";"
        })
    })
};