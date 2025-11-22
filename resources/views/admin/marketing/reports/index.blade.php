@extends('layouts.admin')

@section('title', 'Marketing Reports')
@section('header', 'Marketing Reports')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Revenue</h3>
            <p class="text-3xl font-bold text-indigo-600">$12,450.00</p>
            <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Orders</h3>
            <p class="text-3xl font-bold text-indigo-600">124</p>
            <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Conversion Rate</h3>
            <p class="text-3xl font-bold text-indigo-600">3.2%</p>
            <p class="text-sm text-gray-500 mt-1">Last 30 days</p>
        </div>
    </div>

    <!-- Sales Chart Controls -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 md:mb-0">Sales Report</h2>
            <div class="flex flex-wrap gap-3">
                <select id="report-period" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly" selected>Monthly</option>
                    <option value="yearly">Yearly</option>
                </select>
                <input type="date" id="start-date" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <input type="date" id="end-date" class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <button id="apply-filters" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Apply
                </button>
            </div>
        </div>
        
        <!-- Chart placeholder -->
        <div class="h-80 bg-gray-50 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
            <canvas id="salesChart" class="w-full h-full"></canvas>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Quick Access</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.marketing.reports.stock') }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white p-6 rounded-lg shadow hover:from-yellow-600 hover:to-yellow-700 transition duration-150 ease-in-out">
                <h3 class="text-lg font-semibold mb-2">Stock Management</h3>
                <p class="text-sm opacity-80">Monitor inventory levels and low stock alerts</p>
            </a>
            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Sales Overview</h3>
                <p class="text-sm text-gray-600">Review sales performance and trends</p>
            </div>
            <div class="bg-gray-50 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Marketing Analytics</h3>
                <p class="text-sm text-gray-600">Analyze marketing campaign effectiveness</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Selling Products -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Top Selling Products</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Wireless Headphones</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">45</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$1,350.00</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Smart Watch</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">32</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$1,280.00</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Phone Case</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">28</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$560.00</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Bluetooth Speaker</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">22</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$880.00</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Laptop Stand</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">19</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">$570.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Coupons Usage -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Coupon Usage</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Coupon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">WELCOME10</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10% off</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">23 / 50</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">SUMMER20</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$20 off</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 / 30</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">FREESHIP</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Free shipping</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">41 / 100</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">EXPIRED50</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$50 off</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8 / 10</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Expired
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js for the sales chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Sales',
                    data: [12000, 19000, 15000, 18000, 22000, 17000, 20000, 25000, 23000, 21000, 26000, 30000],
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Sales Trend'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection