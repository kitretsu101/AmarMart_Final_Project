<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function index(): View|RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('shop.checkout.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function store(CheckoutRequest $request): RedirectResponse
    {
        if ($this->cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $items = $this->cart->items();

        try {
            $orderId = DB::transaction(function () use ($request, $items) {
                $order = Order::create([
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'customer_address' => $request->customer_address,
                    'total_amount' => $this->cart->total(),
                    'status' => 'pending',
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product']->id,
                        'product_name' => $item['product']->name,
                        'unit_price' => $item['product']->price,
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ]);
                }

                return $order->id;
            });
        } catch (Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Checkout failed: '.$this->oracleMessage($e));
        }

        $this->cart->clear();

        $order = Order::query()->findOrFail($orderId);
        $order->refresh();

        return redirect()
            ->route('invoice.show', $order)
            ->with('success', 'Order placed. Invoice '.$order->invoice_number.' generated.');
    }

    private function oracleMessage(Throwable $e): string
    {
        $message = $e->getMessage();

        if (preg_match('/ORA-\d+:\s*(.+)$/m', $message, $matches)) {
            return trim($matches[1]);
        }

        return 'Unable to complete order. Please check stock and try again.';
    }
}
