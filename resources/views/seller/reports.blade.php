<x-layouts.app>
    <x-dashboard-header>Reports</x-dashboard-header>

    <div class="flex print:hidden justify-between items-center mb-4">
        <h2 class="text-3xl font-semibold">Sales Report</h2>
        <button onclick="window.print()"
            class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-500">
            Print Report
        </button>
    </div>
    <!-- Hidden Table for Printing -->
    <div class="hidden print:block">
        <h2 class="text-[14px] font-bold mb-4">Sales Data</h2>
        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-3 py-1 text-[10px]">Date</th>
                    <th scope="col" class="px-3 py-1 text-[10px]">Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesDates as $index => $date)
                <tr class="bg-white border-b">
                    <td class="px-3 py-1 text-[10px]">{{ $date }}</td>
                    <td class="px-3 py-1 text-[10px]">RM{{ number_format($salesData[$index], 2) }}</td>
                </tr>
                @endforeach
                   <!-- Total Sales Row -->
                   <tr class="bg-gray-100 font-bold">
                    <td class="px-3 py-1 text-[10px]">Total Sales</td>
                    <td class="px-3 py-1 text-[10px]">RM{{ number_format(array_sum($salesData), 2) }}</td>
                </tr>
            </tbody>
        </table>

        <h2 class="text-[14px] font-bold mt-8 mb-4">Frequent Product Category Purchases</h2>
        <div class="py-6" id="print-pie-chart"></div>
        <table class="w-full text-sm text-left text-gray-500 border border-gray-200">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-3 py-1 text-[10px]">Category</th>
                    <th scope="col" class="px-3 py-1 text-[10px]">Total Purchases</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category => $total)
                <tr class="bg-white border-b">
                    <td class="px-3 py-1 text-[10px]">{{ $category }}</td>
                    <td class="px-3 py-1 text-[10px]">{{ $total }}</td>
                </tr>
                @endforeach
                   <!-- Total Purchases Row -->
                   <tr class="bg-gray-100 font-bold">
                    <td class="px-3 py-1 text-[10px]">Total Purchases</td>
                    <td class="px-3 py-1 text-[10px]">{{ array_sum($categories) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="print:hidden">
        <a href="#"
            class="block print:h-full w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <div id="area-chart"></div>
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Total Sales</h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">RM{{ number_format($totalSales, 2) }}</p>
        </a>
    </div>
    <div class="container print:hidden mx-auto p-5">

        <h2 class="text-3xl font-semibold mb-6">Frequent Product Category Purchases</h2>

        <div class="grid grid-cols-2  gap-4">
            <!-- PieChart -->
            <div class="py-6" id="pie-chart"></div>
            <table class="w-full h-max text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Category</th>
                        <th scope="col"r class="px-6 py-3">Total Purchases</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category => $total)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $category }}</td>
                        <td class="px-6 py-4">{{ $total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        `
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    <script>
        const getChartOptions = () => {
            return {
                series: @json(array_values($categories)),
                colors: ["#1C64F2", "#16BDCA", "#9061F9", "#F59E0B", "#EF4444"],
                chart: {
                    height: 420,
                    width: "100%",
                    type: "pie",
                },
                labels: @json(array_keys($categories)),
                legend: {
                    position: "bottom",
                    fontFamily: "Inter, sans-serif",
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                    },
                },
            };
        };

        if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
            chart.render();
        }
    </script>
    

    <script>
        const options = {
        chart: {
            height: "100%",
            maxWidth: "100%",
            type: "area",
            fontFamily: "Inter, sans-serif",
            dropShadow: { enabled: false },
            toolbar: { show: false },
        },
        tooltip: {
            enabled: true,
            x: { show: false },
        },
        fill: {
            type: "gradient",
            gradient: {
                opacityFrom: 0.55,
                opacityTo: 0,
                shade: "#ef1cd7",
                gradientToColors: ["#ef1cd7"],
            },
        },
        dataLabels: { enabled: false },
        stroke: { width: 6 },
        grid: {
            show: false,
            strokeDashArray: 4,
            padding: { left: 2, right: 2, top: 0 },
        },
        series: [
            {
                name: "Sales",
                data: @json($salesData), // Pass sales data from the controller
                color: "#d81a73",
            },
        ],
        xaxis: {
            categories: @json($salesDates), // Pass sales dates from the controller
            labels: { show: true },
            axisBorder: { show: true },
            axisTicks: { show: false },
        },
        yaxis: { show: false },
    };

    if (document.getElementById("area-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("area-chart"), options);
        chart.render();
    }
    </script>


</x-layouts.app>