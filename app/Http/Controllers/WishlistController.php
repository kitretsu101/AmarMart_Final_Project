<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    
    public function index()
    {
        $wishlist = session()->get('wishlist', []);
        $products = collect();

        if (!empty($wishlist)) {
            $products = Product::whereIn('product_id', array_keys($wishlist))->get();
        }

        return view('wishlist', compact('products'));
    }

    
    public function toggle(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $wishlist = session()->get('wishlist', []);
        $added = false;

        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            $message = '"' . $product->name . '" removed from wishlist.';
        } else {
            $wishlist[$id] = [
                'product_id' => $product->product_id,
                'name'       => $product->name,
                'price'      => $product->price,
                'image'      => $product->image,
            ];
            $added = true;
            $message = '"' . $product->name . '" added to wishlist!';
        }

        session()->put('wishlist', $wishlist);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'added'   => $added,
                'count'   => count($wishlist),
                'message' => $message,
            ]);
        }

        return redirect()->back()->with('success', $message);
    }
}
