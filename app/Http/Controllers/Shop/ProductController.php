<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display the product detail page.
     */
    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Load related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        // Load product reviews that are approved
        $reviews = $product->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate average rating
        $averageRating = $reviews->avg('rating');
        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        // Check if product is in user's wishlist
        $inWishlist = false;
        if (auth()->check()) {
            $inWishlist = $product->userWishlist(auth()->id());
        }

        return view('shop.product', compact(
            'product',
            'relatedProducts',
            'reviews',
            'averageRating',
            'ratingCounts',
            'inWishlist'
        ));
    }

    /**
     * Toggle wishlist status for a product.
     */
    public function toggleWishlist(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add items to your wishlist.');
        }

        $user = Auth::user();
        $wishlist = $user->wishlist()->where('product_id', $product->id)->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Removed from wishlist';
            $action = 'removed';
        } else {
            $user->wishlist()->create([
                'product_id' => $product->id
            ]);
            $message = 'Added to wishlist';
            $action = 'added';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'action' => $action
            ]);
        }

        return back()->with('success', $message);
    }
}