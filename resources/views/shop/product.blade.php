@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div x-data="{ quantity: 1, selectedSize: 'S', selectedColor: 0 }">
    <!-- Full-Screen Hero Section -->
    <div class="relative h-screen min-h-[700px] w-full bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ $product->image_path ? asset('storage/' . $product->image_path) : 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?w=1920&q=80' }}');">
        <div class="absolute inset-0 bg-black/40"></div>
        
        <!-- Glassmorphism Product Card -->
        <div class="relative z-10 flex h-full items-center justify-center p-4">
            <div class="w-full max-w-md rounded-2xl bg-white/10 p-6 shadow-2xl backdrop-blur-lg md:p-8">
                <div class="flex flex-col text-white">
                    <h1 class="text-3xl font-bold leading-tight md:text-4xl">{{ $product->name }}</h1>
                    <p class="mt-2 text-2xl font-semibold md:text-3xl">${{ number_format($product->price / 100, 2) }}</p>
                    <p class="mt-4 text-sm leading-relaxed text-gray-200">{{ Str::limit($product->description, 200) }}</p>
                    
                    <div class="mt-6 space-y-5">
                        <!-- Color Selector -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-200">Color</h3>
                            <div class="mt-2 flex items-center gap-3">
                                <button @click="selectedColor = 0" :class="selectedColor === 0 ? 'ring-2 ring-offset-2 ring-white ring-offset-transparent' : 'hover:ring-2 ring-offset-2 ring-white ring-offset-transparent'" class="size-8 rounded-full bg-blue-200 transition-all"></button>
                                <button @click="selectedColor = 1" :class="selectedColor === 1 ? 'ring-2 ring-offset-2 ring-white ring-offset-transparent' : 'hover:ring-2 ring-offset-2 ring-white ring-offset-transparent'" class="size-8 rounded-full bg-pink-200 transition-all"></button>
                                <button @click="selectedColor = 2" :class="selectedColor === 2 ? 'ring-2 ring-offset-2 ring-white ring-offset-transparent' : 'hover:ring-2 ring-offset-2 ring-white ring-offset-transparent'" class="size-8 rounded-full bg-green-200 transition-all"></button>
                            </div>
                        </div>
                        
                        <!-- Size Selector -->
                        <div>
                            <h3 class="text-sm font-medium text-gray-200">Size</h3>
                            <div class="mt-2 flex flex-wrap gap-3">
                                @foreach(['XS', 'S', 'M', 'L', 'XL'] as $size)
                                    <button 
                                        @click="selectedSize = '{{ $size }}'"
                                        :class="selectedSize === '{{ $size }}' ? 'bg-white text-gray-900 border-transparent' : 'bg-transparent text-white border-white/30 hover:bg-white/20'"
                                        class="rounded-lg border px-4 py-2 text-sm font-medium transition-all"
                                        {{ $size === 'XL' && $product->stock_quantity <= 0 ? 'disabled' : '' }}
                                    >
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quantity and Add to Cart -->
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" :value="quantity">
                        
                        <div class="mt-6 flex items-center gap-4">
                            <div class="flex items-center rounded-lg border border-white/30">
                                <button type="button" @click="quantity = Math.max(1, quantity - 1)" class="px-3 py-2 text-gray-300 transition-colors hover:text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span x-text="quantity" class="px-4 text-lg font-medium"></span>
                                <button type="button" @click="quantity = Math.min({{ $product->stock_quantity ?: 10 }}, quantity + 1)" class="px-3 py-2 text-gray-300 transition-colors hover:text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                            <button type="submit" class="h-12 flex-1 min-w-[84px] cursor-pointer flex items-center justify-center overflow-hidden rounded-full bg-white px-8 text-base font-bold leading-normal tracking-[0.015em] text-gray-900 shadow-md transition-colors hover:bg-gray-200" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                                <span class="truncate">Add to Cart</span>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Reviews -->
                    <div class="mt-6 flex items-center justify-center">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($averageRating ?: 0) ? 'fill-current' : '' }}" fill="{{ $i <= round($averageRating ?: 0) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            @endfor
                        </div>
                        <button class="ml-3 text-sm font-medium text-gray-200 hover:underline">({{ $reviews->count() }} Customer Reviews)</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Customer Reviews Section -->
    <div class="w-full bg-white dark:bg-dark-bg py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <h2 class="text-center text-2xl font-bold text-gray-900 dark:text-white md:text-3xl mb-12">Customer Reviews</h2>
            
            @if($reviews->count() > 0)
                <!-- Rating Summary -->
                <div class="max-w-3xl mx-auto mb-12">
                    <div class="flex flex-col md:flex-row items-center justify-center gap-8 mb-8">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-gray-900 dark:text-white">{{ number_format($averageRating, 1) }}</div>
                            <div class="flex justify-center text-yellow-400 my-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= round($averageRating ?: 0) ? 'fill-current' : '' }}" fill="{{ $i <= round($averageRating ?: 0) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Based on {{ $reviews->count() }} reviews</div>
                        </div>
                        
                        <!-- Rating Distribution -->
                        <div class="w-full max-w-sm">
                            @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-sm w-12 text-gray-700 dark:text-gray-300">{{ $i }} star</span>
                                    <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full transition-all" style="width: {{ $reviews->count() > 0 ? ($ratingCounts[$i] / $reviews->count()) * 100 : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm w-8 text-gray-600 dark:text-gray-400">{{ $ratingCounts[$i] }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                
                <!-- Reviews List -->
                <div class="max-w-4xl mx-auto space-y-6">
                    @foreach($reviews as $review)
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $review->user->name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->format('M j, Y') }}</span>
                                    </div>
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : '' }}" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 dark:text-gray-400">No reviews yet. Be the first to review this product!</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Related Products Carousel -->
    @if($relatedProducts->count() > 0)
        <div class="w-full overflow-hidden bg-white dark:bg-dark-bg">
            <div class="relative py-16 md:py-24">
                <h2 class="mb-12 text-center text-2xl font-bold text-gray-900 dark:text-white md:text-3xl">You Might Also Like</h2>
                <div class="relative flex gap-6 md:gap-8 overflow-x-auto snap-x snap-mandatory px-4 md:px-8 pb-4 scrollbar-hide">
                    @foreach($relatedProducts as $relatedProduct)
                        <a href="{{ route('product.show', $relatedProduct->slug) }}" class="flex-none snap-center" style="width: 80vw; max-width: 400px;">
                            <div class="relative group w-full cursor-pointer">
                                <div class="w-full overflow-hidden rounded-lg aspect-[4/5] bg-cover bg-center {{ $relatedProduct->image_path ? '' : 'bg-gray-200 dark:bg-gray-700' }}" 
                                     @if($relatedProduct->image_path)
                                     style="background-image: url('{{ asset('storage/' . $relatedProduct->image_path) }}');"
                                     @endif>
                                    @if(!$relatedProduct->image_path)
                                        <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                            No Image
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/60 to-transparent p-4 md:p-6 rounded-lg">
                                    <div>
                                        <h3 class="font-semibold text-white">{{ $relatedProduct->name }}</h3>
                                        <p class="mt-1 text-gray-300">${{ number_format($relatedProduct->price / 100, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    /* Hide scrollbar for IE, Edge and Firefox */
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
@endsection