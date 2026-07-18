<?php

namespace App\Http\Controllers;

use App\Models\Order;

class InvoiceController extends Controller
{
    /**
     * Display the invoice for a completed order.
     */
    public function show($id)
    {
        $order = Order::with(['orderItems.product'])->findOrFail($id);

        return view('invoice', compact('order'));
    }
}
