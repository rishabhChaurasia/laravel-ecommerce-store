@extends('layouts.admin')

@section('title', 'Product Details - ' . $product->name)
@section('header', 'Product Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center space-x-4 mb-6">
            @if ($product->image_path)
                <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg">
            @else
                <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h3>
                <p class="text-gray-600">SKU: {{ $product->sku }}</p>
                <p class="text-gray-600">Category: {{ $product->category->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 font-semibold">Price:</p>
                <p class="text-gray-900">${{ number_format($product->price / 100, 2) }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 font-semibold">Sale Price:</p>
                <p class="text-gray-900">
                    @if($product->sale_price)
                        ${{ number_format($product->sale_price / 100, 2) }}
                    @else
                        N/A
                    @endif
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 font-semibold">Stock Quantity:</p>
                <p class="text-gray-900">{{ $product->stock_quantity }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 font-semibold">Status:</p>
                <p class="text-gray-900">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                <p class="text-gray-700 font-semibold">Description:</p>
                <p class="text-gray-900">{{ $product->description ?? 'No description provided.' }}</p>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Back to Products
            </a>
            <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Product
            </a>
        </div>
    </div>
</div>
@endsection
