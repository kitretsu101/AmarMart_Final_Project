@extends('layouts.app')

@section('title', 'Checkout — AmarMart')

@section('content')
<section class="checkout-section">
    <div class="container">

        <div class="page-header mb-4">
            <h1 class="page-title"><i class="bi bi-bag-check me-2"></i>Checkout</h1>
        </div>

        {{-- Location status alert (filled by JS) --}}
        <div id="checkoutLocationAlert" class="alert alert-info d-none" role="alert"></div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="checkout-card card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Delivery Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.place-order') }}" method="POST" id="checkoutForm" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('customer_name') is-invalid @enderror"
                                       id="customer_name" name="customer_name"
                                       value="{{ old('customer_name') }}"
                                       placeholder="Enter your full name" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone"
                                           value="{{ old('phone') }}"
                                           placeholder="+880 1700-000000" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email"
                                           value="{{ old('email') }}"
                                           placeholder="you@example.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Current Location (auto-filled, address editable) --}}
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-geo-alt-fill me-1"></i>Current Location
                                </label>
                                <div class="d-flex gap-2 align-items-center mb-2 flex-wrap">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="detectLocationBtn">
                                        <i class="bi bi-crosshair me-1"></i>Refresh Location
                                    </button>
                                    <span id="locationStatus" class="small text-muted">
                                        <span class="spinner-border spinner-border-sm me-1" id="checkoutLocSpinner" role="status"></span>
                                        Loading...
                                    </span>
                                </div>
                                <input type="text"
                                       class="form-control mb-2"
                                       id="location_display"
                                       value="{{ old('location_display', $userLocation['display'] ?? '') }}"
                                       placeholder="City, Country"
                                       readonly>
                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="text"
                                           class="form-control @error('latitude') is-invalid @enderror"
                                           id="latitude" name="latitude"
                                           value="{{ old('latitude', $userLocation['latitude'] ?? '') }}"
                                           placeholder="Latitude" readonly>
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="text"
                                           class="form-control @error('longitude') is-invalid @enderror"
                                           id="longitude" name="longitude"
                                           value="{{ old('longitude', $userLocation['longitude'] ?? '') }}"
                                           placeholder="Longitude" readonly>
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">
                                    Address <span class="text-danger">*</span>
                                    <small class="text-muted">(auto-filled — you may edit)</small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address" name="address" rows="3"
                                              placeholder="House/Apt, Street, City, ZIP" required>{{ old('address', $userLocation['full_address'] ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Google Maps Preview (hidden if permission denied) --}}
                            <div class="mb-4" id="checkoutMapSection">
                                <label class="form-label">Google Maps Preview</label>
                                <div id="mapPreview" class="map-preview border rounded bg-light d-flex align-items-center justify-content-center">
                                    <span class="text-muted small" id="mapPlaceholder">
                                        <i class="bi bi-map me-1"></i>Map will appear after location is detected
                                    </span>
                                    <iframe id="mapFrame" class="d-none w-100 h-100 rounded" style="border:0;min-height:220px;"
                                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                            title="Delivery location map"></iframe>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg place-order-btn" id="placeOrderBtn">
                                    <i class="bi bi-check-circle me-2"></i>Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="checkout-summary-card card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>Your Order</h5>
                    </div>
                    <div class="card-body">
                        <div class="checkout-items">
                            @foreach($cart as $productId => $item)
                                <div class="checkout-item d-flex align-items-center gap-3 mb-3">
                                    <div class="checkout-item-img-wrap">
                                        @if($item['image'] && file_exists(storage_path('app/public/' . $item['image'])))
                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                 alt="{{ $item['name'] }}" class="checkout-item-img">
                                        @else
                                            <div class="cart-img-placeholder"><i class="bi bi-image"></i></div>
                                        @endif
                                        <span class="checkout-qty-badge">{{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="checkout-item-name">{{ $item['name'] }}</div>
                                        <div class="text-muted small">৳{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="checkout-item-subtotal">৳{{ number_format($item['subtotal'], 2) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <hr>
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>৳{{ number_format($total, 2) }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery:</span>
                            <span class="text-success">Free</span>
                        </div>
                        <div class="summary-total mt-2">
                            <span>Grand Total:</span>
                            <span class="grand-total-amount">৳{{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-3">
                    <i class="bi bi-arrow-left me-2"></i>Back to Cart
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
/**
 * Checkout location autofill
 * Listens to global amarmart:location event from location.js
 * Also uses session data already rendered into the form.
 */
(function () {
    const latInput     = document.getElementById('latitude');
    const lngInput     = document.getElementById('longitude');
    const addressInput = document.getElementById('address');
    const displayInput = document.getElementById('location_display');
    const statusEl     = document.getElementById('locationStatus');
    const mapFrame     = document.getElementById('mapFrame');
    const mapPlaceholder = document.getElementById('mapPlaceholder');
    const mapSection   = document.getElementById('checkoutMapSection');
    const alertEl      = document.getElementById('checkoutLocationAlert');
    const btn          = document.getElementById('detectLocationBtn');

    function updateMap(lat, lng) {
        if (!lat || !lng) {
            mapSection?.classList.add('d-none');
            return;
        }
        mapSection?.classList.remove('d-none');
        mapFrame.src = `https://maps.google.com/maps?q=${lat},${lng}&z=15&output=embed`;
        mapFrame.classList.remove('d-none');
        mapPlaceholder?.classList.add('d-none');
    }

    function fillForm(loc) {
        if (!loc) return;
        if (latInput && !latInput.value) latInput.value = loc.latitude ?? '';
        if (lngInput && !lngInput.value) lngInput.value = loc.longitude ?? '';
        // Always refresh lat/lng when location event fires
        if (latInput && loc.latitude != null) latInput.value = loc.latitude;
        if (lngInput && loc.longitude != null) lngInput.value = loc.longitude;
        if (displayInput) displayInput.value = loc.display || '';
        // Only autofill address if empty (user may have edited)
        if (addressInput && !addressInput.value.trim() && loc.full_address) {
            addressInput.value = loc.full_address;
        }
        if (statusEl) {
            statusEl.className = 'small text-success';
            statusEl.innerHTML = '<i class="bi bi-check-circle me-1"></i>Location detected';
        }
        updateMap(loc.latitude, loc.longitude);
        if (alertEl) alertEl.classList.add('d-none');
    }

    function markUnavailable(message) {
        if (statusEl) {
            statusEl.className = 'small text-danger';
            statusEl.innerHTML = '<i class="bi bi-geo-alt me-1"></i>Location unavailable';
        }
        mapSection?.classList.add('d-none');
        if (alertEl) {
            alertEl.className = 'alert alert-warning';
            alertEl.textContent = message || 'Location permission denied. You can still enter your address manually.';
            alertEl.classList.remove('d-none');
        }
    }

    // Prefill from server session on first paint
    @if(!empty($userLocation) && !empty($userLocation['latitude']))
        fillForm(@json($userLocation));
    @endif

    // Also use in-memory location from navbar script
    if (window.AmarMartLocation && window.AmarMartLocation.success !== false) {
        fillForm(window.AmarMartLocation);
    }

    // Listen for async location updates (no page reload)
    window.addEventListener('amarmart:location', function (e) {
        const detail = e.detail || {};
        if (detail.success && detail.location) {
            fillForm(detail.location);
        } else {
            markUnavailable(detail.message);
        }
    });

    // Manual refresh button
    btn?.addEventListener('click', function () {
        if (statusEl) {
            statusEl.className = 'small text-muted';
            statusEl.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Loading...';
        }
        if (typeof window.AmarMartDetectLocation === 'function') {
            // Clear sessionLocation cache so detect runs again
            if (window.AmarMart) window.AmarMart.sessionLocation = null;
            window.AmarMartDetectLocation();
        }
    });
})();
</script>
@endpush
