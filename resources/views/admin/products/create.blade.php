@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<h1 class="h3 mb-4">Add Product</h1>
<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="bg-white border p-4" style="max-width:720px;">
    @csrf
    @include('admin.products._form')
    <button class="btn btn-am">Save Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
</form>
@endsection
