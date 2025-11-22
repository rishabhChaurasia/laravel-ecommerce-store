@extends('layouts.admin')

@section('title', 'Create Coupon')
@section('header', 'Create Coupon')

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

        <form method="POST" action="{{ route('admin.marketing.coupons.store') }}" class="bg-white rounded-lg shadow-md p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Coupon Code</label>
                    <input type="text" id="code" name="code" value="{{ old('code') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Enter a unique coupon code (e.g. SUMMER20)</p>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select id="type" name="type" required class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Type</option>
                        <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                </div>

                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <input type="number" id="value" name="value" value="{{ old('value') }}" step="0.01" required min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">For fixed: amount in dollars. For percentage: discount percentage</p>
                </div>

                <div>
                    <label for="min_amount" class="block text-sm font-medium text-gray-700 mb-2">Minimum Amount (Optional)</label>
                    <input type="number" id="min_amount" name="min_amount" value="{{ old('min_amount') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Minimum order amount required to use this coupon</p>
                </div>

                <div>
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-2">Usage Limit (Optional)</label>
                    <input type="number" id="usage_limit" name="usage_limit" value="{{ old('usage_limit') }}" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Max number of times this coupon can be used (leave blank for unlimited)</p>
                </div>

                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date (Optional)</label>
                    <input type="date" id="expires_at" name="expires_at" value="{{ old('expires_at') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Date when the coupon expires (leave blank for no expiry)</p>
                </div>
            </div>

            <!-- Is Active -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input id="is_active" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Is Active</label>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.marketing.coupons.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection