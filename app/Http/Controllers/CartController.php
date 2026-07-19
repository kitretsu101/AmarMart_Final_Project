<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart  = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('cart', compact('cart', 'total'));
    }

    /**
     * Add a product to the cart (supports AJAX JSON).
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + 1;
            if ($newQty > $product->stock) {
                return $this->cartResponse($request, false, 'Sorry, only ' . $product->stock . ' items in stock.', $cart);
            }
            $cart[$id]['quantity'] = $newQty;
            $cart[$id]['subtotal'] = $newQty * $cart[$id]['price'];
        } else {
            if ($product->stock < 1) {
                return $this->cartResponse($request, false, 'This product is out of stock.', $cart);
            }
            $cart[$id] = [
                'product_id' => $product->product_id,
                'name'       => $product->name,
                'price'      => (float) $product->price,
                'image'      => $product->image,
                'quantity'   => 1,
                'subtotal'   => (float) $product->price,
            ];
        }

        session()->put('cart', $cart);

        return $this->cartResponse(
            $request,
            true,
            '"' . $product->name . '" added to cart!',
            $cart,
            'cart.index'
        );
    }

    /**
     * Update the quantity of a cart item (supports AJAX).
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'required|integer|min:1',
        ]);

        $id       = $request->product_id;
        $quantity = (int) $request->quantity;
        $cart     = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);
            if ($quantity > $product->stock) {
                return $this->cartResponse($request, false, 'Only ' . $product->stock . ' items available.', $cart);
            }
            $cart[$id]['quantity'] = $quantity;
            $cart[$id]['subtotal'] = $quantity * $cart[$id]['price'];
            session()->put('cart', $cart);
        }

        return $this->cartResponse($request, true, 'Cart updated.', $cart);
    }

    /**
     * Increase quantity by 1.
     */
    public function increase(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return $this->cartResponse($request, false, 'Item not found in cart.', $cart);
        }

        $product = Product::findOrFail($id);
        $newQty  = $cart[$id]['quantity'] + 1;

        if ($newQty > $product->stock) {
            return $this->cartResponse($request, false, 'Only ' . $product->stock . ' items available.', $cart);
        }

        $cart[$id]['quantity'] = $newQty;
        $cart[$id]['subtotal'] = $newQty * $cart[$id]['price'];
        session()->put('cart', $cart);

        return $this->cartResponse($request, true, 'Quantity increased.', $cart);
    }

    /**
     * Decrease quantity by 1 (remove at 0).
     */
    public function decrease(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return $this->cartResponse($request, false, 'Item not found in cart.', $cart);
        }

        $newQty = $cart[$id]['quantity'] - 1;

        if ($newQty < 1) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $newQty;
            $cart[$id]['subtotal'] = $newQty * $cart[$id]['price'];
        }

        session()->put('cart', $cart);

        return $this->cartResponse($request, true, 'Quantity decreased.', $cart);
    }

    /**
     * Remove a product from the cart (supports AJAX).
     */
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return $this->cartResponse($request, true, 'Item removed from cart.', $cart);
    }

    /**
     * AJAX cart count endpoint.
     */
    public function count()
    {
        $cart = session()->get('cart', []);

        return response()->json([
            'count' => array_sum(array_column($cart, 'quantity')),
            'total' => $this->calculateTotal($cart),
        ]);
    }

    private function calculateTotal(array $cart): float
    {
        return (float) array_sum(array_column($cart, 'subtotal'));
    }

    private function cartResponse(Request $request, bool $success, string $message, array $cart, ?string $redirectRoute = null)
    {
        $payload = [
            'success' => $success,
            'message' => $message,
            'count'   => array_sum(array_column($cart, 'quantity')),
            'total'   => number_format($this->calculateTotal($cart), 2),
            'cart'    => $cart,
        ];

        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json($payload, $success ? 200 : 422);
        }

        $redirect = $redirectRoute
            ? redirect()->route($redirectRoute)
            : redirect()->back();

        return $redirect->with($success ? 'success' : 'error', $message);
    }
}
