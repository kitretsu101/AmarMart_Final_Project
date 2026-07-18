@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<h1 class="h3 mb-1">Orders</h1>
<p class="text-muted mb-4">Manage customer orders and invoice status.</p>

<div class="bg-white border">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
            <tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Items</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>BDT {{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->items_count }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-muted">No orders yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $orders->links() }}</div>
@endsection
