@extends('layouts.app')

@section('title', 'Wishlist — AmarMart')

@section('content')
<section class="products-section pt-4">
    <div class="container">
        <div class="page-header mb-4">
            <h1 class="page-title"><i class="bi bi-heart me-2"></i>My Wishlist</h1>
            <p class="text-muted">Products saved in your session wishlist</p>
        </div>

        @if($products->count() > 0)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 g-4">
                @foreach($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @endforeach
            </div>
        @else
            <div class="empty-state text-center py-5">
                <i class="bi bi-heart display-1 text-muted"></i>
                <h3 class="mt-3 text-muted">Your wishlist is empty</h3>
                <a href="{{ route('home') }}" class="btn btn-primary mt-2">Browse Products</a>
            </div>
        @endif
    </div>
</section>
@endsection
