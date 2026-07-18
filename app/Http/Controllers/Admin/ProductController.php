<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display all products in admin panel.
     */
    public function index(Request $request)
    {
        $search   = $request->input('search');
        $products = Product::when($search, function ($query, $search) {
                        return $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orderBy('product_id', 'desc')
                    ->paginate(10);

        return view('admin.products.index', compact('products', 'search'));
    }

    /**
     * Show create product form.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a new product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required'   => 'Product name is required.',
            'price.required'  => 'Price is required.',
            'price.numeric'   => 'Price must be a valid number.',
            'stock.required'  => 'Stock quantity is required.',
            'stock.integer'   => 'Stock must be a whole number.',
            'image.required'  => 'Product image is required.',
            'image.image'     => 'The uploaded file must be an image.',
            'image.max'       => 'Image size must not exceed 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product "' . $request->name . '" created successfully!');
    }

    /**
     * Show edit product form.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update an existing product.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required'  => 'Product name is required.',
            'price.required' => 'Price is required.',
            'price.numeric'  => 'Price must be a valid number.',
            'stock.required' => 'Stock quantity is required.',
            'stock.integer'  => 'Stock must be a whole number.',
            'image.image'    => 'The uploaded file must be an image.',
            'image.max'      => 'Image size must not exceed 2MB.',
        ]);

        $imagePath = $product->image;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product "' . $product->name . '" updated successfully!');
    }

    /**
     * Delete a product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image file from storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $productName = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product "' . $productName . '" deleted successfully!');
    }
}
