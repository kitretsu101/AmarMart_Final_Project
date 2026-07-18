@extends('layouts.shop')

@section('title', 'Cart')

@section('content')
<div class="container py-5">
    <h1 class="h2 mb-4">Shopping Cart</h1>

    @if($items->isEmpty())
        <div class="alert alert-light border">Your cart is empty. <a href="{{ route('products.index') }}">Browse products</a></div>
    @else
        <div class="table-responsive bg-white border">
            <table class="table mb-0 align-middle">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th style="width:140px;">Qty</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['product']->name }}</td>
                        <td>BDT {{ number_format($item['product']->price, 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $item['product']) }}" class="d-flex gap-1">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="{{ $item['product']->stock }}" class="form-control form-control-sm">
                                <button class="btn btn-sm btn-outline-secondary">Update</button>
                            </form>
                        </td>
                        <td>BDT {{ number_format($item['subtotal'], 2) }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-secondary">Clear Cart</button>
            </form>
            <div class="text-end">
                <div class="fs-4 mb-2">Total: <span class="price">BDT {{ number_format($total, 2) }}</span></div>
                <a href="{{ route('checkout.index') }}" class="btn btn-accent btn-lg">Proceed to Checkout</a>
            </div>
        </div>
    @endif
</div>
@endsection
