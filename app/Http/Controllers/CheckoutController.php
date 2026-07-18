<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form.
     * Redirect back to cart if cart is empty.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        $total = array_sum(array_column($cart, 'subtotal'));

        return view('checkout', compact('cart', 'total'));
    }

    /**
     * Process the order and place it.
     */
    public function placeOrder(Request $request)
    {
        // Validate checkout form
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'address'       => 'required|string|max:1000',
        ], [
            'customer_name.required' => 'Customer name is required.',
            'phone.required'         => 'Phone number is required.',
            'email.required'         => 'Email address is required.',
            'email.email'            => 'Please enter a valid email address.',
            'address.required'       => 'Delivery address is required.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $totalAmount = array_sum(array_column($cart, 'subtotal'));

        // Generate unique invoice number
        $invoiceNumber = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');

        // Create the order
        $order = Order::create([
            'invoice_number' => $invoiceNumber,
            'customer_name'  => $request->customer_name,
            'phone'          => $request->phone,
            'email'          => $request->email,
            'address'        => $request->address,
            'total_amount'   => $totalAmount,
        ]);

        // Save each order item and reduce stock
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id'   => $order->order_id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'subtotal'   => $item['subtotal'],
            ]);

            // Reduce product stock
            $product = Product::find($productId);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Clear the cart
        session()->forget('cart');

        return redirect()->route('invoice.show', $order->order_id)
                         ->with('success', 'Order placed successfully!');
    }
}
