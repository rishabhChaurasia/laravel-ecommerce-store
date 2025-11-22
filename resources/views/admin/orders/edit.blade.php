@extends('layouts.admin')

@section('title', 'Edit Order - ' . $order->order_number)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Order #{{ $order->order_number }}</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('orders.update', $order) }}" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                    <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $order->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">Order Number</label>
                    <input type="text" name="order_number" id="order_number" value="{{ $order->order_number }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div>
                    <label for="payment_status" class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                    <input type="text" name="payment_method" id="payment_method" value="{{ $order->payment_method }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="grand_total" class="block text-sm font-medium text-gray-700 mb-2">Grand Total (in cents)</label>
                    <input type="number" name="grand_total" id="grand_total" value="{{ $order->grand_total }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Enter amount in cents (e.g., $12.99 = 1299)</p>
                </div>
            </div>

            <!-- Shipping Address Fields -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="shipping_address_first_name" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                        <input type="text" name="shipping_address[first_name]" id="shipping_address_first_name" value="{{ old('shipping_address.first_name', $order->shipping_address['first_name'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="shipping_address_last_name" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="shipping_address[last_name]" id="shipping_address_last_name" value="{{ old('shipping_address.last_name', $order->shipping_address['last_name'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="shipping_address_address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" name="shipping_address[address]" id="shipping_address_address" value="{{ old('shipping_address.address', $order->shipping_address['address'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div>
                        <label for="shipping_address_city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                        <input type="text" name="shipping_address[city]" id="shipping_address_city" value="{{ old('shipping_address.city', $order->shipping_address['city'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="shipping_address_state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                        <input type="text" name="shipping_address[state]" id="shipping_address_state" value="{{ old('shipping_address.state', $order->shipping_address['state'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label for="shipping_address_zipcode" class="block text-sm font-medium text-gray-700 mb-2">ZIP Code</label>
                        <input type="text" name="shipping_address[zipcode]" id="shipping_address_zipcode" value="{{ old('shipping_address.zipcode', $order->shipping_address['zipcode'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label for="shipping_address_country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" name="shipping_address[country]" id="shipping_address_country" value="{{ old('shipping_address.country', $order->shipping_address['country'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Order
                </button>
            </div>
        </form>
    </div>
</div>
@endsection