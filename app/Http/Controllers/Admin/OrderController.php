<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders (read-only) with search + pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $orders = Order::when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('invoice_number', 'like', '%' . $search . '%')
                      ->orWhere('customer_name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('order_id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'search'));
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
