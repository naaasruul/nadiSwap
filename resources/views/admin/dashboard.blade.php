<x-layouts.app :title="__('Admin')">
    <x-dashboard-header>Admin Dashboard</x-dashboard-header>

    <div class="container mx-auto p-5 print:hidden">
         <!-- Print Button -->
         <div class="mb-4 flex justify-end">
            <button onclick="window.print()" 
                class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-pink-400 focus:ring-opacity-75">
                Print Dashboard
            </button>
        </div>
        
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold">Total Users</h3>
                <p class="text-xl font-bold">{{ $users->count() }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold">Total Products</h3>
                <p class="text-xl font-bold">{{ $products->count() }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold">Total Orders</h3>
                <p class="text-xl font-bold">{{ $orders->count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 ">
            <div class="row-span-3 col-span-1 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <h3 class="text-lg text-center font-semibold">Sellers & Buyers</h3>
                <div id="pie-chart" class="w-full"></div>
            </div>
            <div class="row-span-3 col-span-2 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <h3 class="text-lg text-center font-semibold">Transactions</h3>
                <div id="area-chart" class="w-full h-full"></div>
            </div>
            <div class="col-span-2 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <h3 class="text-lg text-center font-semibold mb-4">Rating & Reviews</h3>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                           
                            <th scope="col" class="px-6 py-3">
                                User
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Product
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Rating
                            </th>
                        </tr>
                    </thead>
                    @foreach ($reviews as $review)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4 flex">
                            <img class="w-5 h-5 me-3 rounded-full" src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : 'https://placehold.co/200x200/orange/white?text=' . $review->user->username }}" alt="{{ $review->user->avatar ? "Customer Avatar" : 'Placeholder Avatar' }}" alt="Rounded avatar">{{ $review->user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $review->product->name }}
                        </td>
                        <td class="px-6 py-4">
                            @for ($i = 0; $i < $review->rating; $i++)
                            <i class='fa fa-star text-yellow-300'></i>
                            @endfor
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
            <div class="col-span-1 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <div id="donut-chart" class="w-full h-full"></div>

            </div>
            
        </div>
    </div>        
    <div id="dashboard-content" class="hidden print:block">
        <h1 class='text-3xl text-center mb-2'> ADMIN REPORT </h1>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                <h3 class="text-sm font-semibold">Total Users</h3>
                <p class="text-sm font-bold">{{ $users->count() }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                <h3 class="text-sm font-semibold">Total Products</h3>
                <p class="text-sm font-bold">{{ $products->count() }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                <h3 class="text-sm font-semibold">Total Orders</h3>
                <p class="text-sm font-bold">{{ $orders->count() }}</p>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-4">
            <!-- Sellers -->
            <div class="col-span-4 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <h3 class="text-lg text-center font-semibold">Sellers</h3>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sellers as $seller)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $seller->id }}</td>
                                <td class="px-6 py-4">{{ $seller->name }}</td>
                                <td class="px-6 py-4">{{ $seller->email }}</td>
                                <td class="px-6 py-4">{{ $seller->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Buyers -->
            <div class="col-span-4 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <h3 class="text-lg text-center font-semibold">Buyers</h3>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Email</th>
                                <th scope="col" class="px-6 py-3">Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buyers as $buyer)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $buyer->id }}</td>
                                <td class="px-6 py-4">{{ $buyer->name }}</td>
                                <td class="px-6 py-4">{{ $buyer->email }}</td>
                                <td class="px-6 py-4">{{ $buyer->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Transactions -->
            <div class="row-span-3 col-span-4 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <h3 class="text-lg text-center font-semibold">Transactions</h3>
                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Date</th>
                            <th class="px-6 py-3">Transaction Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactionDates as $index => $date)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $date }}</td>
                            <td class="px-6 py-4">{{ $transactionCounts[$index] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
           <!-- Ratings and Reviews -->
            <div class="col-span-4 border border-pink-200 rounded-lg bg-base-200 p-4 shadow-md">
                <h3 class="text-lg text-center font-semibold mb-4">Rating & Reviews</h3>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">User</th>
                            <th class="px-6 py-3">Product</th>
                            <th class="px-6 py-3">Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 flex">
                                <img class="w-5 h-5 me-3 rounded-full" src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : 'https://placehold.co/200x200/orange/white?text=' . $review->user->username }}" alt="{{ $review->user->avatar ? "Customer Avatar" : 'Placeholder Avatar' }}"
                                    alt="Rounded avatar">{{ $review->user->name }}
                            </td>
                            <td class="px-6 py-4">{{ $review->product->name }}</td>
                            <td class="px-6 py-4">
                                @for ($i = 0; $i < $review->rating; $i++)
                                    <i class='fa fa-star text-yellow-300'></i>
                                    @endfor
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
        <script>
            const getChartOptions = () => {
            return {
                series: [{{ $buyersCount }}, {{ $sellersCount }}], // Buyers and Sellers data
                colors: ["#E74694", "#16BDCA"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                labels: ["Buyers", "Sellers"], // Labels for the chart
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
            };
        };

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
            chart.render();
        }
        </script>

        <script>
            // Line Chart for Transactions Over Time
    const areaChartOptions = {
        chart: {
            height: "100%",
            maxWidth: "100%",
            type: "area",
            fontFamily: "Inter, sans-serif",
            toolbar: {
                show: false,
            },
        },
        tooltip: {
            enabled: true,
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 6,
        },
        grid: {
            show: false,
        },
        series: [
            {
                name: "Transactions",
                data: @json($transactionCounts), // Transaction counts from the controller
                color: "#d81aa9",
            },
        ],
        xaxis: {
            categories: @json($transactionDates), // Transaction dates from the controller
            labels: {
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    fontFamily: "Inter, sans-serif",
                    cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                }
            }
        },
    };

    if (document.getElementById("area-chart") && typeof ApexCharts !== 'undefined') {
        const areaChart = new ApexCharts(document.getElementById("area-chart"), areaChartOptions);
        areaChart.render();
    }
        </script>

<script>
    const getOrdersOptions = () => {
        return {
            series: [{{ $pendingOrders }}, {{ $paidOrders }}, {{ $cancelledOrders }}], // Order status counts
            colors: ["#E74694", "#E5D352", "#56CBF9"],
            chart: {
                height: 320,
                width: "100%",
                type: "donut",
            },
            stroke: {
                colors: ["transparent"],
            },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: 20,
                            },
                            total: {
                                showAlways: true,
                                show: true,
                                label: "Total Orders",
                                fontFamily: "Inter, sans-serif",
                                formatter: function (w) {
                                    const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    return sum;
                                },
                            },
                            value: {
                                show: true,
                                fontFamily: "Inter, sans-serif",
                                offsetY: -20,
                                formatter: function (value) {
                                    return value;
                                },
                            },
                        },
                        size: "80%",
                    },
                },
            },
            grid: {
                padding: {
                    top: -2,
                },
            },
            labels: ["Pending", "Paid", "Cancelled"], // Labels for the chart
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: "bottom",
                fontFamily: "Inter, sans-serif",
            },
        };
    };

    if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("donut-chart"), getOrdersOptions());
        chart.render();
    }
</script>

</x-layouts.app>