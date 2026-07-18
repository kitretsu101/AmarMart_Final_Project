<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display home page with product listing and optional search.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('product_id', 'desc')
                    ->paginate(8);

        return view('home', compact('products', 'search'));
    }

    /**
     * Display a single product's details page.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product-details', compact('product'));
    }
}
