<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts    = Product::count();
        $totalOrders      = Order::count();
        $totalRevenue     = Order::sum('total_amount');
        $lowStockProducts = Product::where('stock', '>', 0)->where('stock', '<', 5)->count();
        $lowStockList     = Product::where('stock', '>', 0)->where('stock', '<', 5)->orderBy('stock')->take(5)->get();
        $latestOrders     = Order::orderBy('order_id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'lowStockProducts',
            'lowStockList',
            'latestOrders'
        ));
    }
}
