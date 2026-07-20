<?php

namespace App\Http\Controllers;

use App\Models\Order;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $order = Order::with(['orderItems.product'])->findOrFail($id);

        return view('invoice', compact('order'));
    }
}
