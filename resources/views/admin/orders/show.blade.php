@extends('layouts.admin')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Order Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($item->unit_price / 100, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    ${{ number_format(($item->unit_price * $item->quantity) / 100, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No items in this order.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Total:</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">${{ number_format($order->grand_total / 100, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Order Status -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Order Status</h2>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Status
                    </button>
                </form>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Customer Information</h2>
                @if($order->user)
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                </div>
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="text-sm text-gray-900">{{ $order->user->email }}</p>
                </div>
                @else
                <p class="text-sm text-gray-900">Guest Order</p>
                @endif
            </div>

            <!-- Shipping Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                <address class="text-sm text-gray-900 not-italic">
                    {{ $order->shipping_address['first_name'] ?? '' }} {{ $order->shipping_address['last_name'] ?? '' }}<br>
                    {{ $order->shipping_address['address'] ?? '' }}<br>
                    {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zipcode'] ?? '' }}<br>
                    {{ $order->shipping_address['country'] ?? '' }}
                </address>
            </div>

            <!-- Payment Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Payment Information</h2>
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                    <p class="text-sm text-gray-900">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $order->payment_status === 'unpaid' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->payment_status === 'refunded' ? 'bg-purple-100 text-purple-800' : '' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </p>
                </div>
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <p class="text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection