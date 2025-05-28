<x-layouts.app :title="__('Admin')">
    <x-dashboard-header>Manage Seller</x-dashboard-header>

    {{-- username,name,number phone& email --}}
    <div class="container mt-6">
        <table id="search-table">
        <thead>
            <tr>
                <th>
                    <span class="flex items-center">
                        No.
                    </span>
                </th>
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
            @foreach ($sellers as $seller)
            <tr>
                <td class="font-medium dark:text-white">{{ $loop->iteration }}</td>
                <td class="font-medium text-gray-900 dark:text-white">{{ $seller->username }}</td>
                <td class=" whitespace-nowrap dark:text-white">{{ $seller->name }}</td>
                <td class=" dark:text-white">{{ $seller->phone_number }}</td>
                <td>{{ $seller->email }}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
    </div>


</x-layouts.app>