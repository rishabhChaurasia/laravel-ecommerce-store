@extends('layouts.app')

@section('title', 'Order Confirmation')
@section('header', 'Order Confirmation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Thank You for Your Order!</h2>
            <p class="text-gray-600 mb-6">Your order #{{ $order->order_number }} has been received and is being processed.</p>
            
            <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                <h3 class="font-semibold text-lg mb-4">Order Details</h3>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-gray-600 text-sm">Order Number</p>
                        <p class="font-medium">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Order Date</p>
                        <p class="font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Status</p>
                        <p class="font-medium">
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
                        <p class="text-gray-600 text-sm">Payment Status</p>
                        <p class="font-medium">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->payment_status === 'unpaid' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->payment_status === 'refunded' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="border-t pt-4">
                    <h4 class="font-medium mb-2">Shipping Address</h4>
                    <p class="text-gray-700">
                        {{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}<br>
                        {{ $order->shipping_address['address'] }}<br>
                        {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zipcode'] }}<br>
                        {{ $order->shipping_address['country'] }}
                    </p>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('account.orders') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-center">
                    View Order History
                </a>
                <a href="{{ route('shop.index') }}" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 text-center">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection