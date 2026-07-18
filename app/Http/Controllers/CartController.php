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
     * Add a product to the cart.
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Increment quantity but cap at available stock
            $newQty = $cart[$id]['quantity'] + 1;
            if ($newQty > $product->stock) {
                return redirect()->back()
                                 ->with('error', 'Sorry, only ' . $product->stock . ' items in stock.');
            }
            $cart[$id]['quantity'] = $newQty;
            $cart[$id]['subtotal'] = $newQty * $cart[$id]['price'];
        } else {
            if ($product->stock < 1) {
                return redirect()->back()->with('error', 'This product is out of stock.');
            }
            $cart[$id] = [
                'product_id'  => $product->product_id,
                'name'        => $product->name,
                'price'       => $product->price,
                'image'       => $product->image,
                'quantity'    => 1,
                'subtotal'    => $product->price,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
                         ->with('success', '"' . $product->name . '" added to cart!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity'   => 'required|integer|min:1',
        ]);

        $id       = $request->product_id;
        $quantity = $request->quantity;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);
            if ($quantity > $product->stock) {
                return redirect()->route('cart.index')
                                 ->with('error', 'Only ' . $product->stock . ' items available.');
            }
            $cart[$id]['quantity'] = $quantity;
            $cart[$id]['subtotal'] = $quantity * $cart[$id]['price'];
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove a product from the cart.
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    /**
     * Calculate the grand total of the cart.
     */
    private function calculateTotal(array $cart): float
    {
        return array_sum(array_column($cart, 'subtotal'));
    }
}
