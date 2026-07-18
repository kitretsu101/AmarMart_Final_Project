@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')

<div class="page-header-admin mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">Add Product</li>
        </ol>
    </nav>
    <h2 class="admin-page-title">Add New Product</h2>
</div>

<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST"
                      enctype="multipart/form-data" id="createProductForm" novalidate>
                    @csrf

                    {{-- Product Name --}}
                    <div class="mb-3">
                        <label for="prod_name" class="form-label">
                            Product Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="prod_name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Enter product name"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-3">
                        <label for="prod_description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="prod_description"
                                  name="description"
                                  rows="4"
                                  placeholder="Enter product description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Price & Stock --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="prod_price" class="form-label">
                                Price (৳) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">৳</span>
                                <input type="number"
                                       class="form-control @error('price') is-invalid @enderror"
                                       id="prod_price"
                                       name="price"
                                       value="{{ old('price') }}"
                                       placeholder="0.00"
                                       min="0"
                                       step="0.01"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="prod_stock" class="form-label">
                                Stock Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('stock') is-invalid @enderror"
                                   id="prod_stock"
                                   name="stock"
                                   value="{{ old('stock', 0) }}"
                                   placeholder="0"
                                   min="0"
                                   required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Product Image --}}
                    <div class="mb-4">
                        <label for="prod_image" class="form-label">
                            Product Image <span class="text-danger">*</span>
                        </label>
                        <input type="file"
                               class="form-control @error('image') is-invalid @enderror"
                               id="prod_image"
                               name="image"
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               required
                               onchange="previewImage(this)">
                        <div class="form-text">Accepted formats: JPG, PNG, GIF, WEBP. Max size: 2MB.</div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        {{-- Image Preview --}}
                        <div class="mt-2" id="imagePreviewWrap" style="display:none;">
                            <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail admin-image-preview">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary" id="saveProductBtn">
                            <i class="bi bi-check-circle me-2"></i>Save Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    const wrap = document.getElementById('imagePreviewWrap');
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            wrap.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
