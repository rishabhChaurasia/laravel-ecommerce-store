@extends('layouts.admin')

@section('title', 'Inventory Management')
@section('header', 'Inventory Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-gray-800">Inventory Management</h1>
                <p class="text-gray-600 mt-1">Manage your product inventory, stock levels, and product status</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add New Product
            </a>
        </div>

        <!-- Inventory Filters -->
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="category_filter" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select id="category_filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status_filter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status_filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <label for="stock_filter" class="block text-sm font-medium text-gray-700 mb-1">Stock Level</label>
                    <select id="stock_filter" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">All Levels</option>
                        <option value="in_stock">In Stock</option>
                        <option value="low_stock">Low Stock (≤ 10)</option>
                        <option value="out_of_stock">Out of Stock</option>
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" id="search" placeholder="Search by name or SKU..." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Inventory Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($product->image_path)
                                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-md mr-3">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded-md mr-3 flex items-center justify-center">
                                        <span class="text-gray-500 text-xs">No Image</span>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->sku }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->category->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($product->price / 100, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <span class="text-sm text-gray-900 mr-2">{{ $product->stock_quantity }}</span>
                                @if($product->stock_quantity == 0)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Out of Stock</span>
                                @elseif($product->stock_quantity <= 10)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Low Stock</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">In Stock</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            No products found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Bulk Actions Section -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Bulk Inventory Actions</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Update Stock Levels -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-medium text-gray-700 mb-2">Update Stock Levels</h3>
                <p class="text-sm text-gray-600 mb-3">Update stock quantities for multiple products at once</p>

                <form method="POST" action="{{ route('admin.marketing.inventory.bulkUpdateStock') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Products</label>
                        <select name="product_ids[]" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Current: {{ $product->stock_quantity }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Stock Quantity</label>
                        <input type="number" name="stock_changes[template]" min="0" placeholder="Enter new quantity for all selected" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">This quantity will be applied to all selected products</p>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                        Update Stock
                    </button>
                </form>
            </div>

            <!-- Change Status -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-medium text-gray-700 mb-2">Change Status</h3>
                <p class="text-sm text-gray-600 mb-3">Activate or deactivate multiple products</p>

                <form method="POST" action="{{ route('admin.marketing.inventory.bulkUpdateStatus') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Products</label>
                        <select name="product_ids[]" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 text-sm">
                        Change Status
                    </button>
                </form>
            </div>

            <!-- Import/Export -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="font-medium text-gray-700 mb-2">Import/Export</h3>
                <p class="text-sm text-gray-600 mb-3">Import or export product data via CSV</p>

                <div class="space-y-2">
                    <a href="{{ route('admin.marketing.inventory.export') }}" class="block px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm text-center">
                        Export Products (CSV)
                    </a>

                    <form method="POST" action="{{ route('admin.marketing.inventory.import') }}" enctype="multipart/form-data" class="mt-3">
                        @csrf
                        <div class="mb-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Import CSV</label>
                            <input type="file" name="csv_file" accept=".csv" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 text-sm w-full">
                            Import Products
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection