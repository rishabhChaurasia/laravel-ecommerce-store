@extends('layouts.admin')

@section('title', 'Review Management')
@section('header', 'Review Management')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Product Reviews</h1>
                <p class="text-gray-600 mt-1">Manage customer reviews and ratings</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.reviews.pending') }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 text-sm">
                    Pending Reviews
                </a>
                <a href="{{ route('admin.reviews.approved') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-sm">
                    Approved Reviews
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($reviews->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reviews as $review)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $review->product->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $review->product->sku ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $review->user->name ?? 'Anonymous' }}</div>
                                <div class="text-sm text-gray-500">{{ $review->user->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    <span class="ml-1 text-sm text-gray-600">({{ $review->rating }})</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $review->comment }}">
                                    {{ Str::limit($review->comment, 100) }}
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $review->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    @if(!$review->is_approved)
                                        <a href="{{ route('admin.reviews.toggleApproval', $review->id) }}" class="text-green-600 hover:text-green-900">Approve</a>
                                    @else
                                        <a href="{{ route('admin.reviews.toggleApproval', $review->id) }}" class="text-yellow-600 hover:text-yellow-900">Unapprove</a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}" class="inline" onsubmit="return confirm('Are you sure you want to reject and delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews</h3>
                    <p class="mt-1 text-sm text-gray-500">You don't have any reviews to manage at the moment.</p>
                </div>
            @endif
        </div>

        @if($reviews->count() > 0)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection