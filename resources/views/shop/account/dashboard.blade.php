@extends('layouts.app')

@section('title', 'Account Dashboard')
@section('header', 'My Account')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6">Account Dashboard</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <h3 class="text-lg font-semibold text-blue-800">Personal Information</h3>
                <p class="text-gray-600 mt-2">{{ Auth::user()->name }}</p>
                <p class="text-gray-600">{{ Auth::user()->email }}</p>
                <a href="{{ route('profile.edit') }}" class="mt-3 inline-block text-blue-600 hover:underline">Edit Profile</a>
            </div>
            
            <div class="bg-green-50 p-4 rounded-lg border border-green-100">
                <h3 class="text-lg font-semibold text-green-800">Order History</h3>
                <p class="text-gray-600 mt-2">You have {{ Auth::user()->orders()->count() }} orders</p>
                <a href="{{ route('account.orders') }}" class="mt-3 inline-block text-green-600 hover:underline">View Orders</a>
            </div>
            
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-100">
                <h3 class="text-lg font-semibold text-purple-800">Wishlist</h3>
                <p class="text-gray-600 mt-2">You have {{ Auth::user()->wishlist()->count() }} items in wishlist</p>
                <a href="{{ route('account.wishlist') }}" class="mt-3 inline-block text-purple-600 hover:underline">View Wishlist</a>
            </div>
        </div>
        
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Quick Links</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('account.orders') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                    <div class="text-blue-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="font-medium">Order History</h3>
                </a>
                
                <a href="{{ route('account.wishlist') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                    <div class="text-red-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="font-medium">Wishlist</h3>
                </a>
                
                <a href="{{ route('cart.index') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                    <div class="text-green-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="font-medium">Shopping Cart</h3>
                </a>
                
                <a href="{{ route('profile.edit') }}" class="bg-white border border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow">
                    <div class="text-gray-600 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="font-medium">Profile</h3>
                </a>
            </div>
        </div>
        
        <div>
            <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
            @if(Auth::user()->orders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(Auth::user()->orders()->latest()->take(5)->get() as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->order_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ route('account.orders') }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">You haven't placed any orders yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection