<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function index(): View
    {
        return view('shop.cart.index', [
            'items' => $this->cart->items(),
            'total' => $this->cart->total(),
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $quantity = (int) ($data['quantity'] ?? 1);

        if ($product->stock < $quantity) {
            return back()->with('error', 'Not enough stock for '.$product->name.'.');
        }

        $this->cart->add((int) $product->id, $quantity);

        return redirect()
            ->route('cart.index')
            ->with('success', $product->name.' added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        if ($data['quantity'] > 0 && $product->stock < $data['quantity']) {
            return back()->with('error', 'Not enough stock for '.$product->name.'.');
        }

        $this->cart->update((int) $product->id, (int) $data['quantity']);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product): RedirectResponse
    {
        $this->cart->remove((int) $product->id);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear(): RedirectResponse
    {
        $this->cart->clear();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
