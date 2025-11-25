@extends('layouts.app')

@section('title', 'Order History')

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
                <div class="flex min-w-72 flex-col gap-2">
                    <p class="text-gray-800 dark:text-white text-4xl font-bold leading-tight tracking-tight">Order History</p>
                    <p class="text-gray-600 dark:text-gray-400 text-base font-normal leading-normal">View and track your orders</p>
                </div>
            </div>

            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-3">
                                        <p class="text-gray-800 dark:text-white text-lg font-bold">Order #{{ $order->order_number }}</p>
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                            {{ $order->status === 'shipped' ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-400' : '' }}
                                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                                        <span>•</span>
                                        <span>{{ $order->items->count() }} {{ $order->items->count() === 1 ? 'item' : 'items' }}</span>
                                        <span>•</span>
                                        <span class="font-medium">Payment: {{ ucfirst($order->payment_status) }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <p class="text-gray-800 dark:text-white text-2xl font-bold">${{ number_format($order->grand_total / 100, 2) }}</p>
                                    <a href="{{ route('account.order.details', $order->id) ?? '#' }}" class="inline-flex items-center justify-center rounded-md bg-gray-900 dark:bg-white px-4 py-2 text-sm font-medium text-white dark:text-gray-900 transition-colors hover:bg-gray-800 dark:hover:bg-gray-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                            
                            @if($order->items->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700/50">
                                    <div class="flex gap-3 overflow-x-auto">
                                        @foreach($order->items->take(4) as $item)
                                            @if($item->product)
                                                <div class="flex-shrink-0">
                                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-900">
                                                        @if($item->product->image_path)
                                                            <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No image</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        @if($order->items->count() > 4)
                                            <div class="flex-shrink-0 w-16 h-16 rounded-lg bg-gray-100 dark:bg-zinc-900 flex items-center justify-center text-sm font-medium text-gray-600 dark:text-gray-400">
                                                +{{ $order->items->count() - 4 }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                @if($orders->hasPages())
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            @else
                <div class="flex min-h-[400px] flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 dark:border-gray-700/50 p-8 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 dark:bg-zinc-900">
                        <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No orders yet</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">You haven't placed any orders yet.</p>
                    <a href="{{ route('shop.index') }}" class="mt-6 inline-flex items-center justify-center rounded-md bg-gray-900 dark:bg-white px-4 py-2 text-sm font-medium text-white dark:text-gray-900 transition-colors hover:bg-gray-800 dark:hover:bg-gray-100">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
