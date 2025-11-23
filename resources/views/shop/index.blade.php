@extends('layouts.app')

@section('title', 'Home')
@section('header', 'Welcome to Our Store')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <section class="mb-16">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-8 md:p-12 text-white">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Summer Collection 2024</h1>
                <p class="text-xl mb-8">Discover our new arrivals and exclusive deals for the season</p>
                <a href="{{ route('shop.index') }}" class="bg-white text-blue-600 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition duration-300">
                    Shop Now
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="mb-16">
        <h2 class="text-3xl font-bold mb-8 text-center">Featured Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($featuredCategories as $category)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}">
                        @if($category->image_path)
                            <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center text-gray-500">
                                No Image
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-center">{{ $category->name }}</h3>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">No categories available yet.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- New Arrivals -->
    <section>
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">New Arrivals</h2>
            <a href="{{ route('shop.index') }}" class="text-blue-600 hover:underline">View All</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($newArrivals as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                    <a href="{{ route('product.show', $product->slug) }}">
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        @else
                            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center text-gray-500">
                                No Image
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-blue-600">
                                    ${{ number_format($product->price / 100, 2) }}
                                    @if($product->sale_price && $product->sale_price < $product->price)
                                        <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($product->sale_price / 100, 2) }}</span>
                                    @endif
                                </span>
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        Sale
                                    </span>
                                @endif
                            </div>
                            @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                                <div class="mt-2 text-xs text-orange-600 font-semibold">
                                    Only {{ $product->stock_quantity }} left!
                                </div>
                            @elseif($product->stock_quantity <= 0)
                                <div class="mt-2 text-xs text-red-600 font-semibold">
                                    Out of Stock
                                </div>
                            @endif
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">No new arrivals available yet.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>
@endsection