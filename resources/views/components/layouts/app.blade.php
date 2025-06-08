<x-layouts.app.sidebar :title="$title ?? null">
    
    @hasrole('buyer')
        <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
    @endhasrole

    @hasanyrole('admin|seller')
        <div class="p-4 print:ml-0 sm:ml-64">
    @endhasanyrole
        <div class="p-4 rounded-lg dark:border-gray-700">
            {{ $slot }}
        </div>

        @stack('modal')
    </div>
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
    @stack('js')
    
    <style>

    </style>
</x-layouts.app.sidebar>