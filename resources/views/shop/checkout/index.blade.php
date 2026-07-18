@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h1 class="h2 mb-4">Checkout</h1>
    <div class="row g-4">
        <div class="col-lg-7">
            <form method="POST" action="{{ route('checkout.store') }}" class="border bg-white p-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="customer_address" rows="3" class="form-control" required>{{ old('customer_address') }}</textarea>
                </div>
                <button class="btn btn-accent">Place Order</button>
            </form>
        </div>
        <div class="col-lg-5">
            <div class="border bg-white p-4">
                <h2 class="h5 mb-3">Order Summary</h2>
                <ul class="list-unstyled mb-3">
                    @foreach($items as $item)
                        <li class="d-flex justify-content-between mb-2">
                            <span>{{ $item['product']->name }} × {{ $item['quantity'] }}</span>
                            <span>BDT {{ number_format($item['subtotal'], 2) }}</span>
                        </li>
                    @endforeach
                </ul>
                <hr>
                <div class="d-flex justify-content-between fs-5">
                    <strong>Total</strong>
                    <strong class="price">BDT {{ number_format($total, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
