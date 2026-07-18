@extends('layouts.admin')

@section('title', $product->name)

@section('content')
<h1 class="h3 mb-3">{{ $product->name }}</h1>
<div class="bg-white border p-4" style="max-width:720px;">
    @if($product->imageUrl())
        <img src="{{ $product->imageUrl() }}" class="img-fluid border mb-3" style="max-height:240px;object-fit:cover;" alt="">
    @endif
    <p>{{ $product->description }}</p>
    <p><strong>Price:</strong> BDT {{ number_format($product->price, 2) }}</p>
    <p><strong>Stock:</strong> {{ $product->stock }}</p>
    <p><strong>Active:</strong> {{ $product->is_active ? 'Yes' : 'No' }}</p>
    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-am">Edit</a>
</div>
@endsection
