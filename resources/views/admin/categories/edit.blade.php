@extends('layouts.admin')

@section('title', 'Edit Category - ' . $category->name)
@section('header', 'Edit Category')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('categories.update', $category) }}" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required autofocus class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Parent Category -->
            <div class="mb-6">
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Category (optional)</label>
                <select id="parent_id" name="parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">No Parent</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Current Image -->
            @if ($category->image_path)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <img src="{{ Storage::url($category->image_path) }}" alt="{{ $category->name }}" class="w-32 h-32 object-cover rounded-md">
                </div>
            @endif

            <!-- New Image -->
            <div class="mb-6">
                <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">New Category Image (optional)</label>
                <input id="image_path" type="file" name="image_path" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Is Active -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Is Active</label>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
