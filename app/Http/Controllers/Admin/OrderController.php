<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display all orders (read-only).
     */
    public function index()
    {
        $orders = Order::orderBy('order_id', 'desc')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display a single order's details (read-only).
     */
    public function show($id)
    {
        $order = Order::with(['orderItems.product'])->findOrFail($id);

        return view('admin.orders.show', compact('order'));
    }
}
