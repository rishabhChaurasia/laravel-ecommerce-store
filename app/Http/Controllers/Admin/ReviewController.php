<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function pending()
    {
        $reviews = Review::with(['user', 'product'])->where('is_approved', false)->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approved()
    {
        $reviews = Review::with(['user', 'product'])->where('is_approved', true)->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review rejected and deleted successfully.');
    }

    public function toggleApproval($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => !$review->is_approved]);

        $status = $review->is_approved ? 'approved' : 'unapproved';
        return redirect()->back()->with('success', "Review {$status} successfully.");
    }
}