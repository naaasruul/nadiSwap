<x-layouts.app :title="__('Admin')">
    <x-dashboard-header>Manage Seller</x-dashboard-header>

    
    <div class="container mt-6">
        <table id="search-table">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        Name
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Ticker
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sellers as $seller)
            <tr>
                <td class="font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $seller->name }}</td>
                <td>{{ $seller->email }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    </div>


</x-layouts.app>