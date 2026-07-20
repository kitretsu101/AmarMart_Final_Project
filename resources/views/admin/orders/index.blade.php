@extends('layouts.admin')

@section('title', 'Orders')

@section('content')

<div class="page-header-admin mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
    <div>
        <h2 class="admin-page-title">Orders</h2>
        <p class="text-muted mb-0">View and search customer orders (read-only)</p>
    </div>
    <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex gap-2">
        <input type="search" name="search" class="form-control"
               placeholder="Search invoice, name, email, phone..."
               value="{{ $search ?? '' }}" style="min-width:260px;">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
        @if(!empty($search))
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Clear</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body p-0">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table admin-table mb-0" id="ordersTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Invoice #</th>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th class="text-end">Total Amount</th>
                            <th>Order Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-light text-dark">{{ $order->invoice_number }}</span>
                                </td>
                                <td class="fw-semibold">{{ $order->customer_name }}</td>
                                <td>{{ $order->phone }}</td>
                                <td class="text-muted small">{{ $order->email }}</td>
                                <td class="text-end fw-semibold">৳{{ number_format($order->total_amount, 2) }}</td>
                                <td class="text-muted small">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->order_id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>View
                                    </a>
                                    <a href="{{ route('invoice.show', $order->order_id) }}"
                                       class="btn btn-sm btn-outline-secondary" target="_blank">
                                        <i class="bi bi-receipt me-1"></i>Invoice
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="d-flex justify-content-center p-4">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-receipt display-4"></i>
                <p class="mt-3">No orders found.</p>
            </div>
        @endif
    </div>
</div>

@endsection
