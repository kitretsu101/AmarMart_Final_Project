@extends('layouts.shop')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            @if($product->imageUrl())
                <img src="{{ $product->imageUrl() }}" class="img-fluid border w-100" style="max-height:480px;object-fit:cover;" alt="{{ $product->name }}">
            @else
                <div class="border bg-light d-flex align-items-center justify-content-center" style="height:360px;">No image</div>
            @endif
        </div>
        <div class="col-lg-6">
            <h1 class="mb-2">{{ $product->name }}</h1>
            <div class="price fs-3 mb-3">BDT {{ number_format($product->price, 2) }}</div>
            <p class="mb-3">{{ $product->description }}</p>
            <p class="text-muted">Available stock: <strong>{{ $product->stock }}</strong></p>

            @if($product->isInStock())
                <form method="POST" action="{{ route('cart.add', $product) }}" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-auto">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control" style="width:100px;">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-accent">Add to Cart</button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning">Out of stock</div>
            @endif
        </div>
    </div>
</div>
@endsection
