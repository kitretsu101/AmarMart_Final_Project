<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $products = Product::query()
            ->active()
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.strtoupper($q).'%';
                $query->whereRaw('UPPER(name) LIKE ?', [$like]);
            })
            ->latest('id')
            ->paginate(12)
            ->withQueryString();

        return view('shop.products.index', compact('products', 'q'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('shop.products.show', compact('product'));
    }
}
