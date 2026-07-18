@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 class="h3 mb-1">Dashboard</h1>
<p class="text-muted mb-4">Statistics loaded from Oracle procedure <code>sp_dashboard_stats</code>.</p>

<div class="row g-3 mb-4">
    <div class="col-md-4 col-xl">
        <div class="stat-box">
            <div class="text-muted">Products</div>
            <div class="fs-3 fw-bold">{{ $stats['total_products'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="stat-box">
            <div class="text-muted">Orders</div>
            <div class="fs-3 fw-bold">{{ $stats['total_orders'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="stat-box">
            <div class="text-muted">Revenue</div>
            <div class="fs-3 fw-bold">BDT {{ number_format($stats['total_revenue'], 2) }}</div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="stat-box">
            <div class="text-muted">Low Stock</div>
            <div class="fs-3 fw-bold">{{ $stats['low_stock'] }}</div>
        </div>
    </div>
    <div class="col-md-4 col-xl">
        <div class="stat-box">
            <div class="text-muted">Pending</div>
            <div class="fs-3 fw-bold">{{ $stats['pending_orders'] }}</div>
        </div>
    </div>
</div>

<div class="bg-white border p-3">
    <h2 class="h5 mb-3">Recent Orders</h2>
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
            <tr>
                <th>Invoice</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($recentOrders as $order)
                <tr>
                    <td>{{ $order->invoice_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>BDT {{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}">View</a></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-muted">No orders yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
