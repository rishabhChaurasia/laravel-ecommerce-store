@extends('layouts.app')

@section('title', 'Order Details')
@section('header', 'Order Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Order #{{ $order->order_number }}</h1>
            <a href="{{ route('account.orders') }}" class="text-blue-600 hover:underline">&larr; Back to Orders</a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="md:col-span-2">
                <h2 class="text-lg font-semibold mb-4">Order Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Order Date</h3>
                        <p class="mt-1">{{ $order->created_at->format('F j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Order Status</h3>
                        <p class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
                        <p class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->payment_status === 'unpaid' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->payment_status === 'refunded' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Payment Method</h3>
                        <p class="mt-1">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    </div>
                </div>
            </div>
            
            <div>
                <h2 class="text-lg font-semibold mb-4">Shipping Address</h2>
                <address class="not-italic">
                    <p>{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</p>
                    <p>{{ $order->shipping_address['address'] }}</p>
                    <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zipcode'] }}</p>
                    <p>{{ $order->shipping_address['country'] }}</p>
                </address>
            </div>
        </div>
        
        <h2 class="text-lg font-semibold mb-4">Order Items</h2>
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
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($item->product->image_path)
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="h-10 w-10 object-cover">
                                    @else
                                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-10 h-10 flex items-center justify-center text-gray-500 text-xs">
                                            No Image
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $item->product->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($item->unit_price / 100, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format(($item->unit_price * $item->quantity) / 100, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-sm font-medium text-gray-900" colspan="3">Subtotal:</th>
                        <td class="px-6 py-3 text-sm text-gray-900">${{ number_format($order->grand_total / 100, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mt-8 flex justify-end">
            <div class="w-full md:w-1/3">
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between mb-1">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->grand_total / 100, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span>Shipping</span>
                        <span>$0.00</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span>Tax</span>
                        <span>$0.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg pt-2 border-t border-gray-200">
                        <span>Total</span>
                        <span>${{ number_format($order->grand_total / 100, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection