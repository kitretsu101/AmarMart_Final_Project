@extends('layouts.shop')

@section('title', $q ? 'Search: '.$q : 'Products')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <h1 class="h2 mb-1">{{ $q ? 'Search results' : 'All Products' }}</h1>
        <p class="text-muted mb-0">
            @if($q)
                Showing matches for “{{ $q }}”
            @else
                Browse the AmarMart catalog.
            @endif
        </p>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-6 col-lg-3">
                <div class="border bg-white h-100">
                    @if($product->imageUrl())
                        <img src="{{ $product->imageUrl() }}" class="product-thumb" alt="{{ $product->name }}">
                    @else
                        <div class="product-thumb d-flex align-items-center justify-content-center text-muted">No image</div>
                    @endif
                    <div class="p-3">
                        <h2 class="h5">{{ $product->name }}</h2>
                        <div class="price mb-1">BDT {{ number_format($product->price, 2) }}</div>
                        <div class="small text-muted mb-3">Stock: {{ $product->stock }}</div>
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-am">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border">No products found.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
