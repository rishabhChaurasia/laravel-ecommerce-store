<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the homepage with hero section, featured categories, and new arrivals.
     */
    public function index()
    {
        // Cache featured categories (active categories with at least one product) for 30 minutes
        $featuredCategories = cache()->remember('featured_categories', 1800, function () {
            return Category::where('is_active', true)
                ->whereHas('products', function($query) {
                    $query->where('is_active', true);
                })
                ->with(['products' => function($query) {
                    $query->where('is_active', true)->limit(4);
                }])
                ->limit(4)
                ->get();
        });

        // Cache new arrivals (latest products) for 30 minutes
        $newArrivals = cache()->remember('new_arrivals', 1800, function () {
            return Product::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        });

        return view('shop.index', compact('featuredCategories', 'newArrivals'));
    }

    /**
     * Display the shop listing page with filters and sorting.
     */
    public function shop(Request $request)
    {
        // Create a cache key based on request parameters
        $cacheKey = 'shop_products_' . md5(serialize($request->all()));

        // Check if we have cached results for this specific request
        $result = cache()->remember($cacheKey, 1800, function () use ($request) {
            $query = Product::query()->where('is_active', true);

            // Filter by category if provided
            if ($request->has('category') && $request->category) {
                $category = Category::where('slug', $request->category)->first();
                if ($category) {
                    $query->where('category_id', $category->id);
                }
            }

            // Filter by price range if provided
            if ($request->has('min_price') && $request->min_price) {
                $query->where('price', '>=', $request->min_price * 100); // Convert to cents
            }
            if ($request->has('max_price') && $request->max_price) {
                $query->where('price', '<=', $request->max_price * 100); // Convert to cents
            }

            // Sorting
            switch ($request->get('sort', 'newest')) {
                case 'price_low_high':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high_low':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_za':
                    $query->orderBy('name', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            // Get products with pagination (12 per page as specified in the plan)
            $products = $query->paginate(12);

            // Get all active categories for the filter sidebar (cached)
            $categories = cache()->remember('all_categories', 3600, function() {
                return Category::where('is_active', true)
                    ->whereHas('products', function($q) {
                        $q->where('is_active', true);
                    })
                    ->get();
            });

            // Add query parameters to pagination links
            $products = $products->appends($request->query());

            // Load wishlist data if user is authenticated
            if (auth()->check()) {
                $userWishlistProductIds = auth()->user()->wishlist()->pluck('product_id')->toArray();
                foreach ($products as $product) {
                    $product->setAttribute('in_wishlist', in_array($product->id, $userWishlistProductIds));
                }
            } else {
                foreach ($products as $product) {
                    $product->setAttribute('in_wishlist', false);
                }
            }

            return [
                'products' => $products,
                'categories' => $categories
            ];
        });

        return view('shop.shop', [
            'products' => $result['products'],
            'categories' => $result['categories']
        ]);
    }
}