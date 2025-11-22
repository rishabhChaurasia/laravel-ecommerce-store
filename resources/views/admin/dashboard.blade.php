@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold mb-4">{{ __("You're logged in as Admin!") }}</h1>

                <!-- Dashboard Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold text-gray-700">Total Orders</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\Order::count() }}</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold text-gray-700">Total Products</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\Product::count() }}</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\User::count() }}</p>
                    </div>
                    <div class="bg-gray-50 p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold text-gray-700">Pending Orders</h3>
                        <p class="text-3xl font-bold text-indigo-600">{{ \App\Models\Order::where('status', 'pending')->count() }}</p>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
                    @if($recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentOrders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->order_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user ? $order->user->name : 'Guest' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($order->grand_total / 100, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No recent orders found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
