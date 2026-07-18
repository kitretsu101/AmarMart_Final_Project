<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Price (BDT)</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '0') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Stock</label>
        <input type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? '0') }}" class="form-control" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Image</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @isset($product)
        @if($product->imageUrl())
            <img src="{{ $product->imageUrl() }}" alt="" class="mt-2 border" style="height:100px;object-fit:cover;">
        @endif
    @endisset
</div>
<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
        {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
</div>
