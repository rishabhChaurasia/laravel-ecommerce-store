@extends('layouts.admin')

@section('title', 'Category Details - ' . $category->name)
@section('header', 'Category Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center space-x-4 mb-6">
            @if ($category->image_path)
                <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded-lg">
            @else
                <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h3>
                <p class="text-gray-600">Slug: {{ $category->slug }}</p>
                <p class="text-gray-600">Parent: {{ $category->parent->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 font-semibold">Status:</p>
                <p class="text-gray-900">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 font-semibold">Created At:</p>
                <p class="text-gray-900">{{ $category->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 font-semibold">Last Updated:</p>
                <p class="text-gray-900">{{ $category->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Back to Categories
            </a>
            <a href="{{ route('categories.edit', $category) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Category
            </a>
        </div>
    </div>
</div>
@endsection
