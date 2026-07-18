@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<h1 class="h3 mb-4">Edit Product</h1>
<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="bg-white border p-4" style="max-width:720px;">
    @csrf
    @method('PUT')
    @include('admin.products._form', ['product' => $product])
    <button class="btn btn-am">Update Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
</form>
@endsection
