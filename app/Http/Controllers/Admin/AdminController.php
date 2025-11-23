<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Cache total sales revenue for 15 minutes (900 seconds)
        $totalSalesRevenue = cache()->remember('admin_dashboard_sales', 900, function () {
            // Calculate total sales revenue from completed orders
            $sales = Order::whereIn('status', ['processing', 'shipped', 'delivered'])
                ->sum('grand_total');

            // Convert from cents to dollars for display
            return $sales / 100;
        });

        // Cache low stock products for 15 minutes (900 seconds)
        $lowStockProducts = cache()->remember('admin_dashboard_low_stock', 900, function () {
            return Product::where('stock_quantity', '<=', 10)
                ->where('is_active', true)
                ->orderBy('stock_quantity', 'asc')
                ->get();
        });

        // Cache recent orders for 15 minutes (900 seconds)
        $recentOrders = cache()->remember('admin_dashboard_recent_orders', 900, function () {
            return Order::with('user')->latest()->take(5)->get();
        });

        return view('admin.dashboard', compact('totalSalesRevenue', 'lowStockProducts', 'recentOrders'));
    }
}
