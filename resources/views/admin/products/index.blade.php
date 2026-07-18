@extends('layouts.admin')

@section('title', 'Products')

@section('content')

<div class="page-header-admin d-flex align-items-center justify-content-between mb-4">
    <div>
        <h2 class="admin-page-title">Products</h2>
        <p class="text-muted mb-0">Manage your product catalogue</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary" id="addProductBtn">
        <i class="bi bi-plus-circle me-2"></i>Add Product
    </a>
</div>

{{-- Search --}}
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.products.index') }}" method="GET" id="productSearchForm">
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="search"
                       class="form-control"
                       name="search"
                       placeholder="Search products by name..."
                       value="{{ $search ?? '' }}"
                       id="adminProductSearch">
                <button class="btn btn-primary" type="submit">Search</button>
                @if($search)
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Products Table --}}
<div class="card">
    <div class="card-body p-0">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table admin-table mb-0" id="productsTable">
                    <thead>
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $product->product_id }}</td>
                                <td>
                                    @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="admin-product-thumb">
                                    @else
                                        <div class="admin-thumb-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <div class="text-muted small">{{ Str::limit($product->description, 60) }}</div>
                                </td>
                                <td class="text-end fw-semibold">৳{{ number_format($product->price, 2) }}</td>
                                <td class="text-center">
                                    @if($product->stock == 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @elseif($product->stock < 5)
                                        <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.products.edit', $product->product_id) }}"
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product->product_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Delete product: {{ addslashes($product->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="d-flex justify-content-center p-4">
                    {{ $products->appends(['search' => $search])->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-box-seam display-4"></i>
                <p class="mt-3">No products found.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add First Product</a>
            </div>
        @endif
    </div>
</div>

@endsection
