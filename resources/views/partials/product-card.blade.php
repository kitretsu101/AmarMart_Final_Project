@php
    $wishlist = session()->get('wishlist', []);
    $inWishlist = isset($wishlist[$product->product_id]);
@endphp
<div class="col">
    <div class="card product-card h-100">
        <div class="product-card-img-wrap">
            @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="product-card-img">
            @else
                <div class="product-img-placeholder">
                    <i class="bi bi-image"></i>
                </div>
            @endif

            @if($product->stock < 5 && $product->stock > 0)
                <span class="badge bg-warning product-badge">Low Stock</span>
            @elseif($product->stock == 0)
                <span class="badge bg-danger product-badge">Out of Stock</span>
            @endif

            <button type="button"
                    class="btn btn-sm btn-light wishlist-btn {{ $inWishlist ? 'active' : '' }}"
                    data-wishlist-toggle="{{ $product->product_id }}"
                    title="Wishlist"
                    aria-label="Toggle wishlist">
                <i class="bi bi-heart{{ $inWishlist ? '-fill' : '' }}"></i>
            </button>
        </div>

        <div class="card-body d-flex flex-column">
            <h3 class="product-name">{{ $product->name }}</h3>
            <p class="product-desc text-muted">
                {{ \Illuminate\Support\Str::limit($product->description, 80) }}
            </p>
            <div class="mt-auto">
                <div class="product-price">৳{{ number_format($product->price, 2) }}</div>
                <div class="d-grid gap-2 mt-2">
                    <a href="{{ route('product.show', $product->product_id) }}"
                       class="btn btn-primary btn-sm view-details-btn">
                        <i class="bi bi-eye me-1"></i>View Details
                    </a>
                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-outline-secondary btn-sm flex-fill"
                                data-quick-view="{{ $product->product_id }}">
                            <i class="bi bi-zoom-in me-1"></i>Quick View
                        </button>
                        @if($product->stock > 0)
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm flex-fill"
                                    data-ajax-add-cart="{{ $product->product_id }}">
                                <i class="bi bi-cart-plus"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
