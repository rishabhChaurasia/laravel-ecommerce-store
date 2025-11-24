<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50" x-data="{ mobileMenuOpen: false, searchOpen: false }">
        <!-- Announcement Bar -->
        <div class="bg-indigo-600 text-white text-xs font-medium py-2 text-center px-4">
            <p>🎉 Free shipping on all orders over $50! <a href="{{ route('shop.index') }}" class="underline hover:text-indigo-100 ml-1">Shop Now</a></p>
        </div>

        <div class="min-h-screen flex flex-col">
            <!-- Navigation -->
            <nav class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <!-- Left Section: Logo & Desktop Nav -->
                        <div class="flex items-center gap-8">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent hover:opacity-80 transition">
                                    {{ config('app.name', 'LaraStore') }}
                                </a>
                            </div>

                            <!-- Desktop Nav Links -->
                            <div class="hidden md:flex space-x-6">
                                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors duration-200 {{ request()->routeIs('home') ? 'text-indigo-600' : '' }}">
                                    Home
                                </a>
                                <a href="{{ route('shop.index') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition-colors duration-200 {{ request()->routeIs('shop.*') ? 'text-indigo-600' : '' }}">
                                    Shop
                                </a>
                            </div>
                        </div>

                        <!-- Right Section: Search, Cart, Auth -->
                        <div class="flex items-center gap-4">
                            <!-- Search Bar (Desktop) -->
                            <div class="hidden md:block relative">
                                <form action="{{ route('shop.index') }}" method="GET">
                                    <input type="text" name="search" placeholder="Search products..." class="w-64 pl-10 pr-4 py-1.5 bg-gray-100 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-0 rounded-full text-sm transition-all duration-200">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </div>
                                </form>
                            </div>

                             <!-- Search Icon (Mobile) -->
                            <button @click="searchOpen = !searchOpen" class="md:hidden text-gray-500 hover:text-indigo-600 transition">
                                 <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>

                            <!-- Cart -->
                            <a href="{{ route('cart.index') }}" class="group relative text-gray-500 hover:text-indigo-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:scale-110 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                                @php
                                    $cartCount = 0;
                                    if(Auth::check()) {
                                        $cart = \App\Models\Cart::where('user_id', Auth::id())->first();
                                        $cartCount = $cart ? $cart->items->count() : 0;
                                    } else {
                                        $cartCount = session('cart') ? count(session('cart')) : 0;
                                    }
                                @endphp
                                @if($cartCount > 0)
                                    <span class="absolute -top-1.5 -right-1.5 bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full shadow-sm border border-white">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            </a>

                            <!-- Auth Dropdown -->
                            @auth
                                <div class="relative ml-2" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition focus:outline-none">
                                        <span class="hidden sm:block">{{ Auth::user()->name }}</span>
                                        <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold uppercase border border-indigo-200">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                        <svg class="h-4 w-4 text-gray-400" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 border border-gray-100 z-50 origin-top-right" style="display: none;">
                                        
                                        <div class="px-4 py-2 border-b border-gray-50">
                                            <p class="text-xs text-gray-500">Signed in as</p>
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->email }}</p>
                                        </div>
                                        
                                        <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition">Dashboard</a>
                                        
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="hidden sm:flex items-center gap-3">
                                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-600 transition">Log in</a>
                                    <a href="{{ route('register') }}" class="text-sm font-medium bg-gray-900 text-white px-4 py-2 rounded-full hover:bg-gray-800 transition shadow-sm hover:shadow-md">Sign up</a>
                                </div>
                            @endauth

                            <!-- Mobile Menu Button -->
                            <div class="flex items-center md:hidden">
                                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-indigo-600 focus:outline-none p-2">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile Search Bar (Expandable) -->
                    <div x-show="searchOpen" class="md:hidden pb-4" x-transition>
                         <form action="{{ route('shop.index') }}" method="GET">
                            <input type="text" name="search" placeholder="Search products..." class="w-full pl-4 pr-4 py-2 bg-gray-100 border-transparent focus:bg-white focus:border-indigo-500 focus:ring-0 rounded-lg text-sm transition-all duration-200">
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="md:hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-lg" style="display: none;">
                    <div class="pt-2 pb-4 space-y-1 px-4">
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            Home
                        </a>
                        <a href="{{ route('shop.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition {{ request()->routeIs('shop.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                            Shop
                        </a>

                        @auth
                            <div class="border-t border-gray-100 mt-4 pt-4">
                                <div class="flex items-center px-3 mb-3">
                                    <div class="shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold uppercase">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                        <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                                <a href="{{ route('account.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 transition">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50 transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="border-t border-gray-100 mt-4 pt-4 grid grid-cols-2 gap-4">
                                <a href="{{ route('login') }}" class="block text-center px-4 py-2 border border-gray-300 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 transition">
                                    Log in
                                </a>
                                <a href="{{ route('register') }}" class="block text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-base font-medium text-white hover:bg-indigo-700 transition">
                                    Sign up
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @hasSection('header')
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            @yield('header')
                        </h2>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow">
                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 mt-auto">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-gray-400 text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'LaraStore') }}. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
