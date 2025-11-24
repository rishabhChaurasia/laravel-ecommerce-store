@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="flex flex-1 justify-center">
    <div class="flex flex-col w-full max-w-7xl flex-1 px-4 md:px-8">
        
        <!-- Hero Section -->
        <div class="relative h-[60vh] md:h-[80vh] w-full mt-4 rounded-2xl overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" 
                 style="background-image: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&q=80');">
            </div>
            <div class="absolute inset-0 bg-black/30 dark:bg-black/50"></div>
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white px-4">
                <h1 class="text-4xl md:text-7xl font-black leading-tight tracking-tighter">Spring Collection</h1>
                <p class="mt-4 text-lg md:text-xl max-w-2xl font-light">Fresh silhouettes and timeless designs to welcome the new season. Your wardrobe refresh starts here.</p>
                <a href="{{ route('shop.index') }}" class="mt-8 flex min-w-[84px] max-w-[240px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-8 bg-white text-gray-900 text-base font-bold leading-normal tracking-[0.015em] hover:bg-gray-200 transition-colors shadow-md">
                    <span class="truncate">Explore Now</span>
                </a>
            </div>
        </div>

        <!-- Curated Categories Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 my-16 md:my-24">
            <div class="flex flex-col justify-center items-start text-left p-4">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">Curated For You</h2>
                <p class="mt-4 text-gray-600 dark:text-gray-300">Discover our handpicked selections, from everyday essentials to statement pieces that define your style.</p>
                <a class="mt-6 text-black dark:text-white font-semibold hover:underline" href="{{ route('shop.index') }}">View All Categories</a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @php
                    $displayCategories = $featuredCategories->take(2);
                @endphp
                @foreach($displayCategories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group flex flex-col items-start gap-3 cursor-pointer">
                        <div class="w-full aspect-square bg-cover bg-center rounded-lg overflow-hidden {{ $category->image_path ? '' : 'bg-gray-200 dark:bg-gray-700' }}" 
                             @if($category->image_path)
                             style="background-image: url('{{ asset('storage/' . $category->image_path) }}');"
                             @endif>
                            @if(!$category->image_path)
                                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:underline">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $category->description ?? 'Explore our collection' }}</p>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- New Arrivals Section -->
        <div class="my-16 md:my-24">
            <h2 class="text-center text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-12">New This Week</h2>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8">
                @php
                    $productArray = $newArrivals->take(6)->values();
                @endphp
                
                @if($productArray->count() > 0)
                    <!-- Large Product 1 -->
                    <a href="{{ route('product.show', $productArray[0]->slug) }}" class="md:col-span-6 flex flex-col group cursor-pointer">
                        <div class="bg-cover bg-center w-full aspect-square rounded-lg overflow-hidden {{ $productArray[0]->image_path ? '' : 'bg-gray-200 dark:bg-gray-700' }}" 
                             @if($productArray[0]->image_path)
                             style="background-image: url('{{ asset('storage/' . $productArray[0]->image_path) }}');"
                             @endif>
                            @if(!$productArray[0]->image_path)
                                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    No Image
                                </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 group-hover:underline">{{ $productArray[0]->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">${{ number_format($productArray[0]->price / 100, 2) }}</p>
                        </div>
                    </a>
                @endif

                <!-- Right Column -->
                <div class="md:col-span-6 flex flex-col justify-between gap-6 md:gap-8">
                    @if($productArray->count() > 1)
                        <!-- Product 2 -->
                        <a href="{{ route('product.show', $productArray[1]->slug) }}" class="flex flex-col group cursor-pointer">
                            <div class="bg-cover bg-center w-full aspect-[16/9] rounded-lg overflow-hidden {{ $productArray[1]->image_path ? '' : 'bg-gray-200 dark:bg-gray-700' }}" 
                                 @if($productArray[1]->image_path)
                                 style="background-image: url('{{ asset('storage/' . $productArray[1]->image_path) }}');"
                                 @endif>
                                @if(!$productArray[1]->image_path)
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        No Image
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 group-hover:underline">{{ $productArray[1]->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">${{ number_format($productArray[1]->price / 100, 2) }}</p>
                            </div>
                        </a>
                    @endif
                    
                    <div class="hidden md:block border-t border-gray-200 dark:border-gray-700"></div>
                    
                    <a class="hidden md:flex items-center gap-2 text-black dark:text-white font-semibold hover:underline" href="{{ route('shop.index') }}">
                        <span>Shop All New Arrivals</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                @if($productArray->count() > 2)
                    @for($i = 2; $i < min(5, $productArray->count()); $i++)
                        <!-- Small Products -->
                        <a href="{{ route('product.show', $productArray[$i]->slug) }}" class="md:col-span-4 flex flex-col group cursor-pointer">
                            <div class="bg-cover bg-center w-full aspect-[4/5] rounded-lg overflow-hidden {{ $productArray[$i]->image_path ? '' : 'bg-gray-200 dark:bg-gray-700' }}" 
                                 @if($productArray[$i]->image_path)
                                 style="background-image: url('{{ asset('storage/' . $productArray[$i]->image_path) }}');"
                                 @endif>
                                @if(!$productArray[$i]->image_path)
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        No Image
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 group-hover:underline">{{ $productArray[$i]->name }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">${{ number_format($productArray[$i]->price / 100, 2) }}</p>
                            </div>
                        </a>
                    @endfor
                @endif

                <!-- Mobile "View All" Link -->
                <a class="md:hidden mt-6 flex items-center justify-center gap-2 text-black dark:text-white font-semibold hover:underline col-span-full" href="{{ route('shop.index') }}">
                    <span>Shop All New Arrivals</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection