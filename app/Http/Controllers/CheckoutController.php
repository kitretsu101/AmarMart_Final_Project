<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        $total = array_sum(array_column($cart, 'subtotal'));

        // Prefill checkout from session location (set by navbar Geolocation + Nominatim)
        $userLocation = session('user_location');

        return view('checkout', compact('cart', 'total', 'userLocation'));
    }

    
    public function placeOrder(CheckoutRequest $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error', 'Your cart is empty.');
        }

        $totalAmount   = array_sum(array_column($cart, 'subtotal'));
        $invoiceNumber = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');

        $order = DB::transaction(function () use ($request, $cart, $totalAmount, $invoiceNumber) {
            $order = Order::create([
                'invoice_number' => $invoiceNumber,
                'customer_name'  => $request->customer_name,
                'phone'          => $request->phone,
                'email'          => $request->email,
                'address'        => $request->address,
                'latitude'       => $request->latitude,
                'longitude'      => $request->longitude,
                'total_amount'   => $totalAmount,
            ]);

            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id'   => $order->order_id,
                    'product_id' => $productId,
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                    'subtotal'   => $item['subtotal'],
                ]);

                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('invoice.show', $order->order_id)
                         ->with('success', 'Order placed successfully!');
    }
}
