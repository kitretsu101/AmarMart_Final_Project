@extends('layouts.admin')

@section('title', 'Order #' . $order->invoice_number)

@section('content')

<div class="page-header-admin mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
            <li class="breadcrumb-item active">{{ $order->invoice_number }}</li>
        </ol>
    </nav>
    <h2 class="admin-page-title">Order Details</h2>
</div>

<div class="row g-4">
    {{-- Customer Info --}}
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>Customer Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0 admin-detail-table">
                    <tr>
                        <th class="text-muted fw-normal">Invoice #</th>
                        <td><span class="badge bg-primary">{{ $order->invoice_number }}</span></td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Customer</th>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Phone</th>
                        <td>{{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Email</th>
                        <td>{{ $order->email }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Address</th>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Order Date</th>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Order Items --}}
    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-bag me-2"></i>Ordered Products</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table admin-table mb-0" id="adminOrderItemsTable">
                        <thead>
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $index => $item)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $item->product->name ?? 'Deleted Product' }}</div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end">৳{{ number_format($item->price, 2) }}</td>
                                    <td class="text-end pe-4">৳{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="4" class="text-end fw-bold ps-4">Grand Total:</td>
                                <td class="text-end pe-4 fw-bold text-primary fs-5">
                                    ৳{{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex gap-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Orders
    </a>
    <a href="{{ route('invoice.show', $order->order_id) }}" class="btn btn-outline-primary" target="_blank">
        <i class="bi bi-receipt me-2"></i>View Invoice
    </a>
</div>

@endsection
