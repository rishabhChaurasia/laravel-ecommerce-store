@extends('layouts.app')

@section('title', 'My Wishlist')
@section('header', 'My Wishlist')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Wishlist</h1>
            <span class="text-gray-600">{{ $wishlistItems->count() }} items</span>
        </div>
        
        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $item)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('product.show', $item->product->slug) }}">
                            @if($item->product->image_path)
                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center text-gray-500">
                                    No Image
                                </div>
                            @endif
                        </a>
                        
                        <div class="p-4">
                            <a href="{{ route('product.show', $item->product->slug) }}">
                                <h3 class="font-semibold text-lg mb-1 hover:text-blue-600 transition-colors">{{ $item->product->name }}</h3>
                            </a>
                            
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-lg font-bold text-blue-600">
                                    ${{ number_format($item->product->price / 100, 2) }}
                                    @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                        <span class="text-sm text-gray-500 line-through ml-2">${{ number_format($item->product->sale_price / 100, 2) }}</span>
                                    @endif
                                </span>
                                @if($item->product->sale_price && $item->product->sale_price < $item->product->price)
                                    <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        Sale
                                    </span>
                                @endif
                            </div>
                            
                            @if($item->product->stock_quantity <= 5 && $item->product->stock_quantity > 0)
                                <div class="text-xs text-orange-600 font-semibold mb-3">
                                    Only {{ $item->product->stock_quantity }} left!
                                </div>
                            @elseif($item->product->stock_quantity <= 0)
                                <div class="text-xs text-red-600 font-semibold mb-3">
                                    Out of Stock
                                </div>
                            @endif
                            
                            <div class="flex justify-between">
                                <form action="{{ route('cart.add') }}" method="POST" class="flex-1 mr-2">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button 
                                        type="submit" 
                                        class="w-full bg-blue-600 text-white py-2 px-4 rounded text-sm hover:bg-blue-700 transition duration-300 {{ $item->product->stock_quantity <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                                        {{ $item->product->stock_quantity <= 0 ? 'disabled' : '' }}
                                    >
                                        Add to Cart
                                    </button>
                                </form>
                                
                                <form 
                                    action="{{ route('wishlist.remove', $item->product) }}" 
                                    method="POST" 
                                    class="ml-2"
                                    onsubmit="return confirm('Are you sure you want to remove this item from your wishlist?');"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="w-full bg-gray-200 text-gray-700 py-2 px-3 rounded text-sm hover:bg-gray-300 transition duration-300"
                                        title="Remove from Wishlist"
                                    >
                                        <svg 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5" 
                                            viewBox="0 0 20 20" 
                                            fill="currentColor"
                                        >
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $wishlistItems->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Your wishlist is empty</h3>
                <p class="mt-1 text-gray-500">Add items you love to your wishlist for later.</p>
                <div class="mt-6">
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
                        Start Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection