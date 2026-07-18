@extends('layouts.app')

@section('title', 'Shopping Cart — AmarMart')

@section('content')
    <section class="cart-section">
        <div class="container">

            <div class="page-header mb-4">
                <h1 class="page-title"><i class="bi bi-cart3 me-2"></i>Shopping Cart</h1>
            </div>

            @if(empty($cart))
                {{-- Empty Cart --}}
                <div class="empty-state text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                    <h3 class="mt-3 text-muted">Your Cart is Empty</h3>
                    <p class="text-muted">Looks like you haven't added any products yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-bag me-1"></i>Start Shopping
                    </a>
                </div>
            @else
                <div class="row g-4">
                    {{-- Cart Items --}}
                    <div class="col-lg-8">
                        <div class="cart-card card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table cart-table mb-0" id="cartTable">
                                        <thead>
                                            <tr>
                                                <th class="ps-4">Product</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Subtotal</th>
                                                <th class="text-center">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cart as $productId => $item)
                                                <tr class="cart-item-row">
                                                    {{-- Product --}}
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="cart-item-img-wrap">
                                                                @if($item['image'] && file_exists(storage_path('app/public/' . $item['image'])))
                                                                    <img src="{{ asset('storage/' . $item['image']) }}"
                                                                        alt="{{ $item['name'] }}" class="cart-item-img">
                                                                @else
                                                                    <div class="cart-img-placeholder">
                                                                        <i class="bi bi-image"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <div class="cart-item-name">{{ $item['name'] }}</div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    {{-- Price --}}
                                                    <td class="text-center align-middle">
                                                        <span class="cart-price">৳{{ number_format($item['price'], 2) }}</span>
                                                    </td>

                                                    {{-- Quantity --}}
                                                    <td class="text-center align-middle">
                                                        <form action="{{ route('cart.update') }}" method="POST" class="qty-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="product_id" value="{{ $productId }}">
                                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                                    min="1" class="form-control qty-input" aria-label="Quantity"
                                                                    onchange="this.form.submit()">
                                                            </div>
                                                        </form>
                                                    </td>

                                                    {{-- Subtotal --}}
                                                    <td class="text-center align-middle">
                                                        <span
                                                            class="cart-subtotal">৳{{ number_format($item['subtotal'], 2) }}</span>
                                                    </td>

                                                    {{-- Remove --}}
                                                    <td class="text-center align-middle">
                                                        <form action="{{ route('cart.remove', $productId) }}" method="POST"
                                                            onsubmit="return confirm('Remove this item from cart?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm remove-btn"
                                                                aria-label="Remove {{ $item['name'] }} from cart">
                                                                <i class="bi bi-trash3"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Summary --}}
                    <div class="col-lg-4">
                        <div class="cart-summary-card card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="summary-row">
                                    <span>Total Items:</span>
                                    <span class="fw-semibold">
                                        {{ array_sum(array_column($cart, 'quantity')) }}
                                    </span>
                                </div>
                                <div class="summary-row">
                                    <span>Subtotal:</span>
                                    <span class="fw-semibold">৳{{ number_format($total, 2) }}</span>
                                </div>
                                <div class="summary-row">
                                    <span>Delivery:</span>
                                    <span class="text-success fw-semibold">Free</span>
                                </div>
                                <hr>
                                <div class="summary-total">
                                    <span>Grand Total:</span>
                                    <span class="grand-total-amount">৳{{ number_format($total, 2) }}</span>
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg checkout-btn">
                                        <i class="bi bi-bag-check me-2"></i>Proceed to Checkout
                                    </a>
                                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                        <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection