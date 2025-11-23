@extends('layouts.app')

@section('title', 'Checkout - Cart Review')
@section('header', 'Checkout - Cart Review')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Review Your Order</h2>
            
            <div class="space-y-4">
                @forelse($cartItems as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div class="flex items-center">
                            @if($item->product)
                                @if($item->product->image_path)
                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center text-gray-500 text-xs">
                                        No Image
                                    </div>
                                @endif
                                <div class="ml-4">
                                    <h3 class="font-medium">{{ $item->product->name }}</h3>
                                    <p class="text-gray-600 text-sm">SKU: {{ $item->product->sku }}</p>
                                </div>
                            @else
                                <div class="ml-4">
                                    <h3 class="font-medium">{{ $item->name }}</h3>
                                    <p class="text-gray-600 text-sm">SKU: {{ $item->sku }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="text-right">
                            <p class="font-medium">${{ number_format(($item->product ? $item->product->price : $item->price) / 100, 2) }}</p>
                            <p class="text-gray-600">Qty: {{ $item->quantity ?? $item->quantity }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-8 text-gray-600">Your cart is empty.</p>
                @endforelse
            </div>
            
            <div class="mt-6 pt-4 border-t">
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Subtotal</span>
                    <span>${{ number_format($cartTotal / 100, 2) }}</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Shipping</span>
                    <span>$0.00</span>
                </div>
                <div class="flex justify-between mb-2">
                    <span class="font-medium">Tax</span>
                    <span>$0.00</span>
                </div>
                <div class="flex justify-between font-bold text-lg pt-2 border-t">
                    <span>Total</span>
                    <span>${{ number_format($cartTotal / 100, 2) }}</span>
                </div>
            </div>
        </div>
        
        <div class="flex justify-between">
            <a href="{{ route('cart.index') }}" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                &larr; Back to Cart
            </a>
            <a href="{{ route('checkout.shipping') }}" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Continue to Shipping &rarr;
            </a>
        </div>
    </div>
</div>
@endsection