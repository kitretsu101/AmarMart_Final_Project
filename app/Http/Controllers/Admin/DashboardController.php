<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with summary statistics.
     */
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders   = Order::count();
        $totalRevenue  = Order::sum('total_amount');
        $latestOrders  = Order::orderBy('order_id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'latestOrders'
        ));
    }
}
