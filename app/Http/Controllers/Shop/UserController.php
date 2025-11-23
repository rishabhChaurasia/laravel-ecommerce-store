<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the user account dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        return view('shop.account.dashboard', compact('user'));
    }

    /**
     * Display the user's order history.
     */
    public function orderHistory()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('shop.account.orders', compact('orders'));
    }

    /**
     * Display the user's wishlist.
     */
    public function wishlist()
    {
        $wishlistItems = Auth::user()->wishlist()
            ->with('product')
            ->paginate(12);

        return view('shop.account.wishlist', compact('wishlistItems'));
    }

    /**
     * Display an order details page.
     */
    public function orderDetails(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.product']);

        return view('shop.account.order-details', compact('order'));
    }

    /**
     * Remove an item from the wishlist.
     */
    public function removeFromWishlist(Request $request, Product $product)
    {
        $user = Auth::user();
        $wishlistItem = $user->wishlist()->where('product_id', $product->id)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $message = 'Removed from wishlist';
        } else {
            $message = 'Item not found in wishlist';
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}