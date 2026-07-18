@extends('layouts.app')

@section('title', 'Checkout — AmarMart')

@section('content')
<section class="checkout-section">
    <div class="container">

        <div class="page-header mb-4">
            <h1 class="page-title"><i class="bi bi-bag-check me-2"></i>Checkout</h1>
        </div>

        <div class="row g-4">
            {{-- Checkout Form --}}
            <div class="col-lg-7">
                <div class="checkout-card card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Delivery Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.place-order') }}" method="POST" id="checkoutForm" novalidate>
                            @csrf

                            {{-- Customer Name --}}
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">
                                    Customer Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('customer_name') is-invalid @enderror"
                                       id="customer_name"
                                       name="customer_name"
                                       value="{{ old('customer_name') }}"
                                       placeholder="Enter your full name"
                                       required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           placeholder="+880 1700-000000"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email Address --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="you@example.com"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Delivery Address --}}
                            <div class="mb-4">
                                <label for="address" class="form-label">
                                    Delivery Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              placeholder="House/Apt, Street, City, ZIP"
                                              required>{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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

            {{-- Order Summary --}}
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
                                                 alt="{{ $item['name'] }}"
                                                 class="checkout-item-img">
                                        @else
                                            <div class="cart-img-placeholder">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                        <span class="checkout-qty-badge">{{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="checkout-item-name">{{ $item['name'] }}</div>
                                        <div class="text-muted small">৳{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</div>
                                    </div>
                                    <div class="checkout-item-subtotal">
                                        ৳{{ number_format($item['subtotal'], 2) }}
                                    </div>
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

                        <div class="security-note mt-3">
                            <i class="bi bi-lock-fill text-success me-1"></i>
                            <small class="text-muted">Secure checkout. No payment required.</small>
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
