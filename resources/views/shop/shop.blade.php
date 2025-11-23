@extends('layouts.app')

@section('title', 'Shop')
@section('header', 'Our Products')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="lg:w-1/4">
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h3 class="text-lg font-semibold mb-4">Filters</h3>
                
                <!-- Category Filter -->
                <div class="mb-6">
                    <h4 class="font-medium mb-2">Categories</h4>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('shop.index') }}" class="block py-1 {{ !request('category') ? 'font-semibold text-blue-600' : 'text-gray-700 hover:text-blue-600' }}">
                                All Categories
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a 
                                    href="{{ route('shop.index', array_merge(request()->query(), ['category' => $category->slug])) }}" 
                                    class="block py-1 {{ request('category') == $category->slug ? 'font-semibold text-blue-600' : 'text-gray-700 hover:text-blue-600' }}"
                                >
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Price Filter -->
                <div class="mb-6">
                    <h4 class="font-medium mb-2">Price Range</h4>
                    <form method="GET" action="{{ route('shop.index') }}" id="priceFilterForm">
                        <!-- Preserve other query parameters -->
                        @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <div class="space-y-4">
                            <div>
                                <label for="min_price" class="block text-sm text-gray-600 mb-1">Min Price</label>
                                <input 
                                    type="number" 
                                    id="min_price" 
                                    name="min_price" 
                                    value="{{ request('min_price') }}" 
                                    placeholder="0" 
                                    min="0"
                                    class="w-full p-2 border border-gray-300 rounded"
                                >
                            </div>
                            <div>
                                <label for="max_price" class="block text-sm text-gray-600 mb-1">Max Price</label>
                                <input 
                                    type="number" 
                                    id="max_price" 
                                    name="max_price" 
                                    value="{{ request('max_price') }}" 
                                    placeholder="1000" 
                                    min="0"
                                    class="w-full p-2 border border-gray-300 rounded"
                                >
                            </div>
                            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition duration-300">
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="lg:w-3/4">
            <!-- Sorting and Results Info -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <p class="text-gray-600">
                        Showing {{ $products->count() }} of {{ $products->total() }} products
                    </p>
                </div>
                
                <div class="flex flex-wrap gap-4">
                    <form method="GET" action="{{ route('shop.index') }}" class="flex items-center">
                        <!-- Preserve other query parameters -->
                        @foreach(request()->except(['sort', 'page']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        
                        <label for="sort" class="mr-2 text-gray-600">Sort by:</label>
                        <select 
                            name="sort" 
                            id="sort" 
                            onchange="this.form.submit()"
                            class="border border-gray-300 rounded px-3 py-2"
                        >
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>Name: A to Z</option>
                            <option value="name_za" {{ request('sort') == 'name_za' ? 'selected' : '' }}>Name: Z to A</option>
                        </select>
                    </form>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('product.show', $product->slug) }}">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center text-gray-500">
                                    No Image
                                </div>
                            @endif
                        </a>
                        
                        <div class="p-4">
                            <a href="{{ route('product.show', $product->slug) }}">
                                <h3 class="font-semibold text-lg mb-1 hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                            </a>
                            
                            <div class="flex justify-between items-center mb-2">
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
                                <div class="text-xs text-orange-600 font-semibold mb-2">
                                    Only {{ $product->stock_quantity }} left!
                                </div>
                            @elseif($product->stock_quantity <= 0)
                                <div class="text-xs text-red-600 font-semibold mb-2">
                                    Out of Stock
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center mt-4">
                                <form action="{{ route('cart.add') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button 
                                        type="submit" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition duration-300"
                                        {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}
                                    >
                                        Add to Cart
                                    </button>
                                </form>

                                @auth
                                    <form
                                        action="{{ route('wishlist.toggle', $product) }}"
                                        method="POST"
                                        class="inline"
                                        id="wishlist-form-{{ $product->id }}"
                                    >
                                        @csrf
                                        <button
                                            type="submit"
                                            class="text-gray-500 hover:text-red-500 transition-colors"
                                            title="Add to Wishlist"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6"
                                                fill="{{ $product->in_wishlist ? 'currentColor' : 'none' }}"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                                />
                                            </svg>
                                        </button>
                                    </form>
                                @endauth
                                
                                @guest
                                    <a 
                                        href="{{ route('login') }}" 
                                        class="text-gray-500 hover:text-red-500 transition-colors"
                                        title="Add to Wishlist"
                                    >
                                        <svg 
                                            xmlns="http://www.w3.org/2000/svg" 
                                            class="h-6 w-6" 
                                            fill="none" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor"
                                        >
                                            <path 
                                                stroke-linecap="round" 
                                                stroke-linejoin="round" 
                                                stroke-width="2" 
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" 
                                            />
                                        </svg>
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <h3 class="text-xl font-semibold mb-2">No products found</h3>
                        <p class="text-gray-600">Try adjusting your filters or check back later.</p>
                        <a href="{{ route('shop.index') }}" class="text-blue-600 hover:underline mt-4 inline-block">Clear Filters</a>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </main>
    </div>
</div>

@push('scripts')
<script>
    // Update wishlist icon on click
    document.querySelectorAll('[id^="wishlist-form-"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    const icon = form.querySelector('svg');
                    if(data.action === 'added') {
                        icon.setAttribute('fill', 'currentColor');
                    } else {
                        icon.setAttribute('fill', 'none');
                    }
                    
                    // Show temporary message
                    const tempMessage = document.createElement('div');
                    tempMessage.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50';
                    tempMessage.textContent = data.message;
                    document.body.appendChild(tempMessage);
                    
                    setTimeout(() => {
                        tempMessage.remove();
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endpush
@endsection