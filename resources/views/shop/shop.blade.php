@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="container mx-auto flex flex-1 px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex w-full flex-col lg:flex-row lg:gap-12">
        
        <!-- Sticky Left Sidebar for Filters -->
        <aside class="w-full lg:w-1/5 lg:sticky lg:top-28 h-fit mb-8 lg:mb-0">
            <div class="flex flex-col gap-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Refine Your Search</h1>
                
                <!-- Categories Filter -->
                <div>
                    <h2 class="text-lg font-bold leading-tight tracking-tight text-left pb-4 text-gray-900 dark:text-white">Categories</h2>
                    <div class="flex flex-col gap-y-1">
                        @foreach($categories as $category)
                            <label class="flex gap-x-3 py-2 flex-row items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="categories[]" 
                                    value="{{ $category->slug }}"
                                    {{ request('category') == $category->slug ? 'checked' : '' }}
                                    onchange="window.location.href='{{ route('shop.index', array_merge(request()->except('category'), request('category') == $category->slug ? [] : ['category' => $category->slug])) }}'"
                                    class="h-5 w-5 rounded border-gray-300 dark:border-gray-600 border-2 bg-transparent text-primary checked:bg-primary checked:border-primary focus:ring-0 focus:ring-offset-0"
                                />
                                <p class="text-base font-normal text-gray-700 dark:text-gray-300">{{ $category->name }}</p>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Price Filter -->
                <div>
                    <h2 class="text-lg font-bold leading-tight tracking-tight text-left pb-4 text-gray-900 dark:text-white">Price</h2>
                    <div class="@container">
                        <div class="relative flex w-full flex-col items-start justify-between gap-4">
                            <div class="flex w-full shrink-[3] items-center justify-between">
                                <p class="text-base font-medium text-gray-700 dark:text-gray-300">Up to</p>
                                <p class="text-sm font-normal text-gray-600 dark:text-gray-400">$350</p>
                            </div>
                            <div class="flex h-4 w-full items-center">
                                <div class="relative w-full h-1.5 bg-gray-300 dark:bg-gray-700 rounded-full">
                                    <div class="h-full rounded-full bg-primary" style="width: 70%;"></div>
                                    <div class="absolute top-1/2 -translate-y-1/2" style="left: 70%; transform: translate(-50%, -50%);">
                                        <div class="size-4 rounded-full bg-primary ring-2 ring-white dark:ring-dark-bg"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Apply Filters Button -->
                <button class="w-full flex cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 bg-primary text-white gap-2 text-base font-bold leading-normal tracking-wide hover:bg-primary/90 transition-colors">
                    Apply Filters
                </button>
            </div>
        </aside>
        
        <!-- Product Grid Area -->
        <div class="w-full lg:w-4/5">
            <!-- Header with Breadcrumbs and Sorting -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <nav aria-label="Breadcrumb">
                    <ol class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <li><a class="hover:text-primary transition-colors" href="{{ route('home') }}">Home</a></li>
                        <li>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </li>
                        <li><a class="hover:text-primary transition-colors" href="{{ route('shop.index') }}">Shop</a></li>
                        @if(request('category'))
                            <li>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </li>
                            <li class="font-medium text-gray-900 dark:text-white">{{ $categories->where('slug', request('category'))->first()->name ?? 'Category' }}</li>
                        @endif
                    </ol>
                </nav>
                <div class="flex items-center gap-3">
                    <label class="text-sm text-gray-700 dark:text-gray-300" for="sort">Sort by:</label>
                    <select 
                        class="form-select rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-sm focus:ring-1 focus:ring-primary focus:border-primary text-gray-900 dark:text-white" 
                        id="sort"
                        onchange="window.location.href='{{ route('shop.index', array_merge(request()->except('sort'), ['sort' => ''])) }}'.replace('sort=', 'sort='+this.value)"
                    >
                        <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="best_selling" {{ request('sort') == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
                    </select>
                </div>
            </div>
            
            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white dark:bg-zinc-900 p-4 rounded-3xl  w-full flex flex-col items-center transition-all duration-300" x-data="{ wishlist: false }">
                        <!-- Product Image Container -->
                        <div class="relative w-full mb-4">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <div class="aspect-square bg-zinc-200 dark:bg-zinc-700 rounded-2xl flex items-center justify-center overflow-hidden">
                                    @if($product->image_path)
                                        <img 
                                            class="w-full h-full object-cover" 
                                            src="{{ asset('storage/' . $product->image_path) }}" 
                                            alt="{{ $product->name }}"
                                        />
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-sm">No Image</span>
                                    @endif
                                </div>
                            </a>
                            
                            <!-- Wishlist Button -->
                            <button 
                                @click.prevent="wishlist = !wishlist"
                                class="absolute top-3 right-3 bg-white/50 dark:bg-zinc-900/50 backdrop-blur-sm p-2 rounded-full transition-colors"
                                :class="wishlist ? 'text-red-500' : 'text-zinc-600 dark:text-zinc-300 hover:text-red-500 dark:hover:text-red-500'"
                            >
                                <svg class="w-5 h-5 transition-all duration-300" :class="wishlist ? 'fill-current' : 'fill-none'" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Product Info -->
                        <div class="w-full text-center">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <h3 class="font-medium text-md text-zinc-800 dark:text-zinc-100">{{ $product->name }}</h3>
                                <p class="font-bold text-2xl text-zinc-900 dark:text-white mt-1">${{ number_format($product->price / 100, 2) }}</p>
                            </a>
                        </div>

                        <!-- Add to Cart Button -->
                        <form action="{{ route('cart.add') }}" method="POST" class="w-full mt-6">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button 
                                type="submit"
                                class="bg-[#020202] dark:bg-white text-white dark:text-[#020202] w-full py-3 rounded-xl flex items-center justify-center gap-2 font-medium  text-sm hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                {{ $product->stock_quantity <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">No products found.</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">Try adjusting your filters</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Load More Button -->
            @if($products->hasMorePages())
                <div class="flex items-center justify-center mt-12">
                    <a href="{{ $products->nextPageUrl() }}" class="bg-[#020202] dark:bg-white text-white dark:text-[#020202] px-12 py-4 rounded-xl font-semibold text-lg hover:opacity-90 transition-opacity inline-flex items-center justify-center gap-2">
                        Load More
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-primary {
        background-color: #B87333;
    }
    .text-primary {
        color: #B87333;
    }
    .hover\:text-primary:hover {
        color: #B87333;
    }
    .border-primary {
        border-color: #B87333;
    }
    .ring-primary {
        --tw-ring-color: #B87333;
    }
    .focus\:ring-primary:focus {
        --tw-ring-color: #B87333;
    }
    .focus\:border-primary:focus {
        border-color: #B87333;
    }
    .checked\:bg-primary:checked {
        background-color: #B87333;
    }
    .checked\:border-primary:checked {
        border-color: #B87333;
    }
    .hover\:bg-primary\/90:hover {
        background-color: rgba(184, 115, 51, 0.9);
    }
</style>
@endsection