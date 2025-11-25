@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="relative flex w-full" style="font-family: 'Inter', sans-serif;">
    <!-- Fixed Vertical Sidebar -->
    <aside class="sticky top-0 flex h-screen w-20 flex-col items-center bg-white py-8 dark:border-gray-700/50 dark:bg-[#101010] lg:w-64 lg:items-stretch lg:px-6 rounded-2xl mt-5 ml-5">
        <div class="flex flex-col gap-8 lg:gap-6">
            <div class="flex items-center gap-3 justify-center lg:justify-start">
                <span class="material-symbols-outlined text-gray-800 dark:text-white text-3xl">storefront</span>
                <span class="hidden text-xl font-bold text-gray-800 dark:text-white lg:inline">LUXE</span>
            </div>
            <div class="flex items-center gap-4 justify-center lg:justify-start">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12 flex items-center justify-center" style="background-color: rgba(192, 161, 114, 0.3);">
                    <span class="material-symbols-outlined text-2xl" style="color: #C0A172;">person</span>
                </div>
                <div class="hidden lg:flex lg:flex-col">
                    <h1 class="text-gray-800 dark:text-white text-base font-medium leading-normal">{{ Auth::user()->name }}</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-normal leading-normal">Welcome</p>
                </div>
            </div>
            <nav class="flex flex-col gap-2">
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50" href="{{ route('account.dashboard') }}">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">person</span>
                    <p class="hidden text-gray-600 dark:text-gray-400 text-sm font-medium leading-normal lg:inline group-hover:text-primary-gold">Profile</p>
                </a>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 dark:bg-opacity-20" style="background-color: rgba(192, 161, 114, 0.1);" href="{{ route('account.orders') }}">
                    <span class="material-symbols-outlined" style="color: #C0A172;">receipt_long</span>
                    <p class="hidden text-sm font-medium leading-normal lg:inline" style="color: #C0A172;">Orders</p>
                </a>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50" href="{{ route('account.wishlist') }}">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">favorite</span>
                    <p class="hidden text-gray-600 dark:text-gray-400 text-sm font-medium leading-normal lg:inline group-hover:text-primary-gold">Wishlist</p>
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-6 lg:p-10 bg-gray-50 dark:bg-[#020202]">
        <div class="mx-auto max-w-7xl">
            <!-- Page Heading -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex min-w-72 flex-col gap-2">
                        <p class="text-gray-800 dark:text-white text-4xl font-bold leading-tight tracking-tight">Order #{{ $order->order_number }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-base font-normal leading-normal">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                    </div>
                    <a href="{{ route('account.orders') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Orders
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Info Cards -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Card -->
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                        <h2 class="text-gray-800 dark:text-white text-lg font-bold mb-4">Order Status</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Order Status</p>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400' : '' }}
                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Payment Status</p>
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $order->payment_status === 'unpaid' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $order->payment_status === 'refunded' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Payment Method</p>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                        <h2 class="text-gray-800 dark:text-white text-lg font-bold mb-4">Order Items</h2>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 pb-4 border-b border-gray-200 dark:border-gray-700/50 last:border-0 last:pb-0">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-900 flex-shrink-0">
                                        @if($item->product->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No image</div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">SKU: {{ $item->product->sku }}</p>
                                        <div class="flex items-center gap-4 mt-2">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Qty: {{ $item->quantity }}</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">×</span>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($item->unit_price / 100, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format(($item->unit_price * $item->quantity) / 100, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Shipping Address -->
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                        <h2 class="text-gray-800 dark:text-white text-lg font-bold mb-4">Shipping Address</h2>
                        <address class="not-italic text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <p class="font-medium text-gray-900 dark:text-white">{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</p>
                            <p>{{ $order->shipping_address['address'] }}</p>
                            <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zipcode'] }}</p>
                            <p>{{ $order->shipping_address['country'] }}</p>
                        </address>
                    </div>

                    <!-- Order Summary -->
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                        <h2 class="text-gray-800 dark:text-white text-lg font-bold mb-4">Order Summary</h2>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-white">${{ number_format($order->grand_total / 100, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                                <span class="text-gray-900 dark:text-white">$0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Tax</span>
                                <span class="text-gray-900 dark:text-white">$0.00</span>
                            </div>
                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700/50">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($order->grand_total / 100, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
