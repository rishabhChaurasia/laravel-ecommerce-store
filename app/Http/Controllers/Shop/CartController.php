<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the shopping cart page.
     */
    public function index()
    {
        $cartItems = collect();
        $cartTotal = 0;
        $cartCount = 0;

        if (Auth::check()) {
            // Authenticated user - get from database
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ], [
                'session_id' => session()->getId(),
                'expires_at' => now()->addDays(30)
            ]);

            // Cache cart items for a short time (5 minutes) for better performance
            $cacheKey = 'user_cart_items_' . Auth::id();
            $cartItems = cache()->remember($cacheKey, 300, function() use ($cart) {
                return $cart->items()->with('product')->get();
            });
        } else {
            // Guest user - get from session
            $cartItems = collect(session()->get('cart', []));
        }

        // Calculate totals
        foreach ($cartItems as $item) {
            $price = $item->product ? $item->product->price : $item['price'];
            $quantity = $item->quantity ?? $item['quantity'];
            $cartTotal += $price * $quantity;
            $cartCount += $quantity;
        }

        return view('shop.cart', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active || $product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Product is not available or insufficient stock.');
        }

        if (Auth::check()) {
            // Authenticated user - use database cart
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ], [
                'session_id' => session()->getId(),
                'expires_at' => now()->addDays(30)
            ]);

            $cartItem = $cart->items()->firstOrNew([
                'product_id' => $product->id
            ]);

            if ($cartItem->exists) {
                $newQuantity = $cartItem->quantity + $request->quantity;
                if ($newQuantity > $product->stock_quantity) {
                    return back()->with('error', 'Not enough stock available.');
                }
                $cartItem->quantity = $newQuantity;
            } else {
                $cartItem->quantity = $request->quantity;
                $cart->items()->save($cartItem);
            }

            $cartItem->save();

            // Clear the user's cart cache
            cache()->forget('user_cart_items_' . Auth::id());
        } else {
            // Guest user - use session cart
            $cart = session()->get('cart', []);

            $productId = $product->id;
            if (isset($cart[$productId])) {
                $newQuantity = $cart[$productId]['quantity'] + $request->quantity;
                if ($newQuantity > $product->stock_quantity) {
                    return back()->with('error', 'Not enough stock available.');
                }
                $cart[$productId]['quantity'] = $newQuantity;
            } else {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image_path' => $product->image_path,
                    'quantity' => $request->quantity,
                    'sku' => $product->sku
                ];
            }

            session()->put('cart', $cart);
        }

        return back()->with('success', $product->name . ' added to cart successfully!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($request->product_id);

        if (Auth::check()) {
            // Authenticated user - update database cart
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);

            $cartItem = $cart->items()->where('product_id', $product->id)->first();

            if ($cartItem) {
                if ($request->quantity <= 0) {
                    $cartItem->delete();
                } else {
                    if ($request->quantity > $product->stock_quantity) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Not enough stock available.'
                        ]);
                    }
                    $cartItem->quantity = $request->quantity;
                    $cartItem->save();
                }
            }

            // Clear the user's cart cache
            cache()->forget('user_cart_items_' . Auth::id());
        } else {
            // Guest user - update session cart
            $cart = session()->get('cart', []);

            $productId = $product->id;
            if (isset($cart[$productId])) {
                if ($request->quantity <= 0) {
                    unset($cart[$productId]);
                } else {
                    if ($request->quantity > $product->stock_quantity) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Not enough stock available.'
                        ]);
                    }
                    $cart[$productId]['quantity'] = $request->quantity;
                }
                session()->put('cart', $cart);
            }
        }

        // Return cart data for AJAX updates
        $cartItems = $this->getCartItems();
        $cartTotal = $this->getCartTotal($cartItems);

        return response()->json([
            'status' => 'success',
            'cart_items' => $cartItems->count(),
            'cart_total' => $cartTotal,
            'message' => 'Cart updated successfully'
        ]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (Auth::check()) {
            // Authenticated user - remove from database cart
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);

            $cart->items()->where('product_id', $request->product_id)->delete();

            // Clear the user's cart cache
            cache()->forget('user_cart_items_' . Auth::id());
        } else {
            // Guest user - remove from session cart
            $cart = session()->get('cart', []);
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart'
        ]);
    }

    /**
     * Helper method to get cart items.
     */
    private function getCartItems()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);
            return $cart->items()->with('product')->get();
        } else {
            $cartData = session()->get('cart', []);
            $cartItems = collect();
            foreach ($cartData as $item) {
                $cartItems->push((object) $item);
            }
            return $cartItems;
        }
    }

    /**
     * Helper method to calculate cart total.
     */
    private function getCartTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $price = $item->product ? $item->product->price : $item->price;
            $quantity = $item->quantity ?? $item->quantity;
            $total += $price * $quantity;
        }
        return $total;
    }
}