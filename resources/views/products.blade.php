@extends('layouts.app')

@section('title', 'Products — AmarMart')

@section('content')
<section class="products-section pt-4">
    <div class="container">
        <div class="section-header d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="section-title"><i class="bi bi-grid me-2"></i>All Products</h1>
                <p class="section-subtitle text-muted">
                    @if($search)
                        Results for "<em>{{ $search }}</em>" — {{ $products->total() }} found
                    @else
                        {{ $products->total() }} product(s) available
                    @endif
                </p>
            </div>
            @if($search)
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle me-1"></i>Clear Search
                </a>
            @endif
        </div>

        @if($products->count() > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="empty-state text-center py-5">
                <i class="bi bi-box-seam display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">No Products Found</h3>
                <a href="{{ route('home') }}" class="btn btn-primary mt-2">Back to Home</a>
            </div>
        @endif
    </div>
</section>
@endsection
