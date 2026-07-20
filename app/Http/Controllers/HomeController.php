<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Display home page with product listing, search, latest & trending.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', Cookie::get('last_search'));

        // Save last search keyword in cookie (7 days)
        if ($request->filled('search')) {
            Cookie::queue('last_search', $request->input('search'), 60 * 24 * 7);
            $search = $request->input('search');
        }

        $products = Product::when($search, function ($query, $search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('product_id', 'desc')
                    ->paginate(8)
                    ->withQueryString();

        // Latest products (most recently added)
        $latestProducts = Product::orderBy('created_at', 'desc')->take(4)->get();

        // Trending = products with most order items sold
        $trendingProducts = Product::withSum('orderItems as sold_qty', 'quantity')
            ->orderByDesc('sold_qty')
            ->take(4)
            ->get();

        return view('home', compact('products', 'search', 'latestProducts', 'trendingProducts'));
    }

    /**
     * Dedicated products listing page (same grid, navbar "Products").
     */
    public function products(Request $request)
    {
        $search = $request->input('search');

        if ($request->filled('search')) {
            Cookie::queue('last_search', $search, 60 * 24 * 7);
        }

        $products = Product::when($search, function ($query, $search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('product_id', 'desc')
                    ->paginate(12)
                    ->withQueryString();

        return view('products', compact('products', 'search'));
    }

    /**
     * Display a single product's details + track recently viewed cookie.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Recently viewed products cookie (JSON array of IDs, max 8, 7 days)
        $viewed = json_decode(request()->cookie('recently_viewed', '[]'), true) ?: [];
        $viewed = array_values(array_unique(array_filter(array_map('intval', $viewed))));
        $viewed = array_values(array_diff($viewed, [(int) $id]));
        array_unshift($viewed, (int) $id);
        $viewed = array_slice($viewed, 0, 8);

        // Badge when this product was already in the recently-viewed cookie
        $previous = json_decode(request()->cookie('recently_viewed', '[]'), true) ?: [];
        $isRecentlyViewed = in_array((int) $id, array_map('intval', $previous), true);

        $wishlist = session()->get('wishlist', []);
        $inWishlist = isset($wishlist[$id]);

        $response = response()->view('product-details', compact('product', 'isRecentlyViewed', 'inWishlist'));
        $response->withCookie(cookie('recently_viewed', json_encode($viewed), 60 * 24 * 7));

        return $response;
    }

    /**
     * Live search suggestions (AJAX JSON).
     */
    public function searchSuggestions(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        if (strlen($q) < 1) {
            return response()->json(['suggestions' => []]);
        }

        Cookie::queue('last_search', $q, 60 * 24 * 7);

        $suggestions = Product::where('name', 'like', '%' . $q . '%')
            ->orderBy('name')
            ->take(8)
            ->get(['product_id', 'name', 'price', 'image', 'stock']);

        return response()->json([
            'suggestions' => $suggestions->map(function ($p) {
                return [
                    'id'    => $p->product_id,
                    'name'  => $p->name,
                    'price' => number_format($p->price, 2),
                    'stock' => $p->stock,
                    'url'   => route('product.show', $p->product_id),
                    'image' => $p->image
                        ? asset('storage/' . $p->image)
                        : asset('images/no-image.svg'),
                ];
            }),
        ]);
    }

    /**
     * Quick view modal data (AJAX JSON).
     */
    public function quickView($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'id'          => $product->product_id,
            'name'        => $product->name,
            'description' => $product->description,
            'price'       => number_format($product->price, 2),
            'stock'       => $product->stock,
            'image'       => $product->image
                ? asset('storage/' . $product->image)
                : asset('images/no-image.svg'),
            'url'         => route('product.show', $product->product_id),
        ]);
    }
}
