@extends('layouts.admin')

@section('title', 'Order '.$order->invoice_number)

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h1 class="h3 mb-1">Order {{ $order->invoice_number }}</h1>
        <p class="text-muted mb-0">Placed {{ optional($order->created_at)->format('Y-m-d H:i') }}</p>
    </div>
    <a href="{{ route('invoice.show', $order) }}" class="btn btn-outline-secondary" target="_blank">Print Invoice</a>
</div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="bg-white border p-3">
            <h2 class="h6">Customer</h2>
            <div>{{ $order->customer_name }}</div>
            <div>{{ $order->customer_email }}</div>
            <div>{{ $order->customer_phone }}</div>
            <div>{{ $order->customer_address }}</div>
        </div>
        <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="bg-white border p-3 mt-3">
            @csrf
            @method('PATCH')
            <label class="form-label">Status</label>
            <select name="status" class="form-select mb-3">
                @foreach(\App\Models\Order::statuses() as $status)
                    <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button class="btn btn-am">Update Status</button>
        </form>
    </div>
    <div class="col-lg-8">
        <div class="bg-white border p-3">
            <table class="table mb-0">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>BDT {{ number_format($item->unit_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>BDT {{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total</th>
                    <th>BDT {{ number_format($order->total_amount, 2) }}</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
