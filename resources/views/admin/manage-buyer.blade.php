<x-layouts.app :title="__('Admin')">
    <x-dashboard-header>Manage Customers</x-dashboard-header>

    
    <div class="container mt-6">
        <table id="search-table">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        Username
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Name
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Phone Number
                    </span>
                </th>
                <th>
                    <span class="flex items-center">
                        Email
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($buyers as $buyer)
            <tr>
                <td class="font-medium text-gray-900  dark:text-white">{{ $buyer->name }}</td>
                <td class=" whitespace-nowrap dark:text-white">{{ $buyer->name }}</td>
                <td class="  dark:text-white">{{ $buyer->phone_number }}</td>
                <td>{{ $buyer->email }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    </div>


</x-layouts.app>