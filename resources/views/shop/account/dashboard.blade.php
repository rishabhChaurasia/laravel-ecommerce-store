@extends('layouts.app')

@section('title', 'Account Dashboard')

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
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 dark:bg-opacity-20" style="background-color: rgba(192, 161, 114, 0.1);" href="{{ route('account.dashboard') }}">
                    <span class="material-symbols-outlined" style="color: #C0A172;">person</span>
                    <p class="hidden text-sm font-medium leading-normal lg:inline" style="color: #C0A172;">Profile</p>
                </a>
                <a class="group flex items-center gap-3 rounded-lg px-3 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50" href="{{ route('account.orders') }}">
                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">receipt_long</span>
                    <p class="hidden text-gray-600 dark:text-gray-400 text-sm font-medium leading-normal lg:inline group-hover:text-primary-gold">Orders</p>
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
                    <p class="text-gray-800 dark:text-white text-4xl font-bold leading-tight tracking-tight">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!</p>
                    <p class="text-gray-600 dark:text-gray-400 text-base font-normal leading-normal">Here's your account at a glance.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Left Column -->
                <div class="flex flex-col gap-8 lg:col-span-2">
                    <!-- Personal Information Card -->
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                        <div class="flex flex-col items-start justify-between gap-6 sm:flex-row">
                            <div class="flex flex-[2_2_0px] flex-col gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <p class="text-gray-800 dark:text-white text-lg font-bold leading-tight">Personal Information</p>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm font-normal leading-normal">{{ Auth::user()->name }}</p>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm font-normal leading-normal">{{ Auth::user()->email }}</p>
                                    @if(Auth::user()->address)
                                        <p class="text-gray-600 dark:text-gray-400 text-sm font-normal leading-normal">{{ Auth::user()->address }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-gray-800 text-white text-sm font-medium leading-normal w-fit hover:bg-gray-700 dark:bg-white dark:text-gray-900 dark:hover:bg-gray-100">
                                    <span class="truncate">Manage Details</span>
                                </a>
                            </div>
                            <div class="w-full flex-1 sm:w-auto">
                                <div class="flex flex-col gap-3">
                                    <div class="flex justify-between gap-6">
                                        <p class="text-gray-800 dark:text-white text-sm font-medium leading-normal">Profile Completion</p>
                                        <p class="text-gray-800 dark:text-white text-sm font-bold leading-normal">{{ Auth::user()->address ? '100' : '80' }}%</p>
                                    </div>
                                    <div class="rounded-full bg-gray-200 dark:bg-gray-700">
                                        <div class="h-2 rounded-full" style="width: {{ Auth::user()->address ? '100' : '80' }}%; background-color: #C0A172;"></div>
                                    </div>
                                    @if(!Auth::user()->address)
                                        <p class="text-gray-600 dark:text-gray-400 text-xs font-normal leading-normal">Add your address to complete your profile.</p>
                                    @else
                                        <p class="text-gray-600 dark:text-gray-400 text-xs font-normal leading-normal">Your profile is complete!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders Section -->
                    <div>
                        <div class="flex items-center justify-between pb-4">
                            <h2 class="text-gray-800 dark:text-white text-[22px] font-bold leading-tight tracking-tight">Recent Orders</h2>
                            <a class="text-sm font-medium hover:underline" style="color: #C0A172;" href="{{ route('account.orders') }}">View All</a>
                        </div>
                        @php
                            $recentOrders = Auth::user()->orders()->with('items.product')->latest()->take(2)->get();
                        @endphp
                        @if($recentOrders->count() > 0)
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                @foreach($recentOrders as $order)
                                    @php
                                        $firstItem = $order->items->first();
                                        $statusColors = [
                                            'pending' => 'text-yellow-600 dark:text-yellow-400',
                                            'processing' => 'text-blue-600 dark:text-blue-400',
                                            'shipped' => 'text-blue-600 dark:text-blue-400',
                                            'delivered' => 'text-green-600 dark:text-green-400',
                                            'cancelled' => 'text-red-600 dark:text-red-400',
                                        ];
                                    @endphp
                                    <div class="flex items-center gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                                        @if($firstItem && $firstItem->product && $firstItem->product->image_url)
                                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-20 shrink-0" style='background-image: url("{{ asset('storage/' . $firstItem->product->image_url) }}");'></div>
                                        @else
                                            <div class="rounded-lg size-20 shrink-0 flex items-center justify-center" style="background-color: rgba(192, 161, 114, 0.2);">
                                                <span class="material-symbols-outlined text-3xl" style="color: #C0A172;">shopping_bag</span>
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <p class="text-gray-800 dark:text-white font-semibold">{{ $firstItem ? $firstItem->product->name : 'Order' }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">#{{ $order->order_number }}</p>
                                            <p class="mt-1 text-xs font-medium {{ $statusColors[$order->status] ?? 'text-gray-600' }}">{{ ucfirst($order->status) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-xl border border-gray-200 bg-white p-8 text-center shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                                <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-5xl">receipt_long</span>
                                <p class="mt-3 text-gray-600 dark:text-gray-400">You haven't placed any orders yet.</p>
                                <a href="{{ route('shop.index') }}" class="mt-4 inline-flex items-center justify-center rounded-lg h-10 px-4 text-white text-sm font-medium" style="background-color: #C0A172;">
                                    Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column / Wishlist -->
                <div class="lg:col-span-1">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700/50 dark:bg-[#101010]">
                        <div class="flex items-center justify-between pb-4">
                            <h2 class="text-gray-800 dark:text-white text-lg font-bold leading-tight">Wishlist</h2>
                            <a class="text-sm font-medium hover:underline" style="color: #C0A172;" href="{{ route('account.wishlist') }}">View All</a>
                        </div>
                        @php
                            $wishlistItems = Auth::user()->wishlist()->with('product')->take(4)->get();
                        @endphp
                        @if($wishlistItems->count() > 0)
                            <div class="flex flex-col gap-5">
                                @foreach($wishlistItems as $wishlistItem)
                                    <div class="flex items-center gap-4">
                                        @if($wishlistItem->product->image_url)
                                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg size-16 shrink-0" style='background-image: url("{{ asset('storage/' . $wishlistItem->product->image_url) }}");'></div>
                                        @else
                                            <div class="rounded-lg size-16 shrink-0 flex items-center justify-center" style="background-color: rgba(192, 161, 114, 0.2);">
                                                <span class="material-symbols-outlined" style="color: #C0A172;">image</span>
                                            </div>
                                        @endif
                                        <div class="flex flex-col">
                                            <p class="font-semibold text-gray-800 dark:text-white">{{ $wishlistItem->product->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">${{ number_format($wishlistItem->product->price / 100, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <span class="material-symbols-outlined text-gray-300 dark:text-gray-600 text-5xl">favorite</span>
                                <p class="mt-3 text-gray-600 dark:text-gray-400 text-sm">Your wishlist is empty.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="mt-8">
                <h2 class="text-gray-800 dark:text-white text-[22px] font-bold leading-tight tracking-tight pb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <a class="flex items-center justify-between rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-all dark:border-gray-700/50 dark:bg-[#101010]" style="transition: all 0.2s;" href="{{ route('password.request') }}">
                        <div class="flex flex-col">
                            <p class="font-semibold text-gray-800 dark:text-white">Update Password</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Enhance your account security.</p>
                        </div>
                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">arrow_forward_ios</span>
                    </a>
                    <a class="flex items-center justify-between rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-all dark:border-gray-700/50 dark:bg-[#101010]" style="transition: all 0.2s;" href="{{ route('profile.edit') }}">
                        <div class="flex flex-col">
                            <p class="font-semibold text-gray-800 dark:text-white">Edit Profile</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Update your personal information.</p>
                        </div>
                        <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">arrow_forward_ios</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection