@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="page-header-admin mb-4">
    <h2 class="admin-page-title">Dashboard</h2>
    <p class="text-muted mb-0">Welcome back, <strong>{{ Auth::user()->name ?? 'Admin' }}</strong>!</p>
</div>

{{-- Stat Cards --}}
<div class="row g-4 mb-5">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card card">
            <div class="card-body">
                <div class="stat-icon stat-icon-blue">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalProducts }}</div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>
            <div class="card-footer stat-footer">
                <a href="{{ route('admin.products.index') }}" class="stat-link">
                    Manage Products <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card card">
            <div class="card-body">
                <div class="stat-icon stat-icon-green">
                    <i class="bi bi-receipt"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $totalOrders }}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
            </div>
            <div class="card-footer stat-footer">
                <a href="{{ route('admin.orders.index') }}" class="stat-link">
                    View Orders <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card card">
            <div class="card-body">
                <div class="stat-icon stat-icon-gold">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">৳{{ number_format($totalRevenue, 2) }}</div>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>
            <div class="card-footer stat-footer">
                <span class="text-muted small">All time revenue</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="stat-card card">
            <div class="card-body">
                <div class="stat-icon" style="background:#fff3cd;color:#856404;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ $lowStockProducts }}</div>
                    <div class="stat-label">Low Stock Products</div>
                </div>
            </div>
            <div class="card-footer stat-footer">
                <span class="text-muted small">Stock between 1 and 4</span>
            </div>
        </div>
    </div>
</div>

{{-- Low Stock List --}}
@if(isset($lowStockList) && $lowStockList->count() > 0)
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Low Stock Alerts</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table admin-table mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockList as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td class="text-center"><span class="badge bg-warning text-dark">{{ $p->stock }}</span></td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $p->product_id) }}" class="btn btn-sm btn-outline-primary">Restock</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- Quick Actions --}}
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-receipt me-2"></i>View All Orders
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary" target="_blank">
                        <i class="bi bi-shop me-2"></i>View Store
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Orders --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Latest Orders</h5>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        @if($latestOrders->count() > 0)
            <div class="table-responsive">
                <table class="table admin-table mb-0">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th class="text-end">Amount</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $order)
                            <tr>
                                <td><span class="badge bg-light text-dark">{{ $order->invoice_number }}</span></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->phone }}</td>
                                <td class="text-end fw-semibold">৳{{ number_format($order->total_amount, 2) }}</td>
                                <td class="text-muted small">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->order_id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4 text-muted">
                <i class="bi bi-inbox display-4"></i>
                <p class="mt-2">No orders yet.</p>
            </div>
        @endif
    </div>
</div>

@endsection
