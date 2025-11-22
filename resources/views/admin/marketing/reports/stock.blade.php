@extends('layouts.admin')

@section('title', 'Stock Management Reports')
@section('header', 'Stock Management Reports')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Total Products</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\Product::count() }}</p>
            <p class="text-sm text-gray-500 mt-1">All products in inventory</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Low Stock Items</h3>
            <p class="text-3xl font-bold text-yellow-600">{{ \App\Models\Product::where('stock_quantity', '<=', 10)->where('is_active', true)->count() }}</p>
            <p class="text-sm text-gray-500 mt-1">Items with stock ≤ 10</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Out of Stock</h3>
            <p class="text-3xl font-bold text-red-600">{{ \App\Models\Product::where('stock_quantity', 0)->where('is_active', true)->count() }}</p>
            <p class="text-sm text-gray-500 mt-1">Currently out of stock</p>
        </div>
    </div>

    <!-- Stock Value -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Inventory Value</h2>
        <div class="text-3xl font-bold text-green-600 mb-2">
            ${{ number_format(\App\Models\Product::where('is_active', true)->sum(\DB::raw('price * stock_quantity')) / 100, 2) }}
        </div>
        <p class="text-sm text-gray-500">Total value of all active products in stock</p>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Low Stock Alerts</h2>
            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full">
                {{ $lowStockProducts->count() }} Items
            </span>
        </div>
        
        @if($lowStockProducts->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($lowStockProducts as $product)
                    <tr class="bg-yellow-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->sku }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->stock_quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Low Stock
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Restock</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-4">No products with low stock alerts</p>
        @endif
    </div>

    <!-- Out of Stock Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Out of Stock Items</h2>
            <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-medium rounded-full">
                {{ $outOfStockProducts->count() }} Items
            </span>
        </div>
        
        @if($outOfStockProducts->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($outOfStockProducts as $product)
                    <tr class="bg-red-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->sku }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Out of Stock
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Restock</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-gray-500 text-center py-4">No out of stock items</p>
        @endif
    </div>

    <!-- Stock Movement Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-6">Stock Level Trend</h2>
        <div class="h-80 bg-gray-50 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
            <canvas id="stockChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>

<!-- Include Chart.js for the stock chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('stockChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Total Stock Quantity',
                    data: [4500, 4800, 4200, 4600, 4100, 4300, 4700, 5100, 4900, 4400, 4600, 5000],
                    backgroundColor: 'rgba(234, 179, 8, 0.6)',
                    borderColor: 'rgba(234, 179, 8, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Stock Level Trend'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection