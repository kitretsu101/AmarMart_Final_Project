@extends('layouts.app')

@section('title', 'Invoice #' . $order->invoice_number . ' — AmarMart')

@section('content')
<section class="invoice-section">
    <div class="container">

        <div class="success-banner text-center mb-4">
            <div class="success-icon-wrap">
                <i class="bi bi-check-circle-fill success-icon"></i>
            </div>
            <h2 class="success-title">Thank you! Your order has been placed successfully.</h2>
            <p class="text-muted">A copy of your invoice is shown below.</p>
        </div>

        <div class="invoice-document" id="invoicePrint">
            <div class="invoice-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="invoice-brand-icon">
                                <i class="bi bi-bag-heart-fill"></i>
                            </div>
                            <div>
                                <h3 class="invoice-brand-name mb-0">AmarMart</h3>
                                <p class="invoice-brand-sub mb-0">Your Trusted Online Store</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <h4 class="invoice-label">INVOICE</h4>
                        <p class="mb-1"><strong>Invoice #:</strong> {{ $order->invoice_number }}</p>
                        <p class="mb-0"><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>

            <hr class="invoice-divider">

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="invoice-section-card">
                        <h6 class="invoice-section-title"><i class="bi bi-person-fill me-2"></i>Billed To</h6>
                        <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
                        <p class="mb-1"><i class="bi bi-telephone me-1"></i>{{ $order->phone }}</p>
                        <p class="mb-1"><i class="bi bi-envelope me-1"></i>{{ $order->email }}</p>
                        <p class="mb-0"><i class="bi bi-geo-alt me-1"></i>{{ $order->address }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="invoice-section-card">
                        <h6 class="invoice-section-title"><i class="bi bi-shop me-2"></i>From</h6>
                        <p class="mb-1"><strong>AmarMart</strong></p>
                        <p class="mb-1"><i class="bi bi-envelope me-1"></i>support@amarmart.com</p>
                        <p class="mb-1"><i class="bi bi-telephone me-1"></i>+880 1700-000000</p>
                        <p class="mb-0"><i class="bi bi-geo-alt me-1"></i>Dhaka, Bangladesh</p>
                    </div>
                </div>
            </div>

            @if($order->latitude && $order->longitude)
            <div class="mb-4">
                <h6 class="invoice-section-title"><i class="bi bi-geo-fill me-2"></i>Current Location</h6>
                <p class="mb-2 small text-muted">
                    Latitude: {{ $order->latitude }} &nbsp;|&nbsp; Longitude: {{ $order->longitude }}
                </p>
                <div class="map-preview border rounded overflow-hidden">
                    <iframe
                        width="100%" height="220" style="border:0;"
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        src="https://maps.google.com/maps?q={{ $order->latitude }},{{ $order->longitude }}&z=15&output=embed"
                        title="Order location map">
                    </iframe>
                </div>
            </div>
            @endif

            <div class="invoice-table-wrap">
                <table class="table invoice-table" id="invoiceItemsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->product->name ?? 'Product Deleted' }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">৳{{ number_format($item->price, 2) }}</td>
                                <td class="text-end">৳{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-semibold">Subtotal:</td>
                            <td class="text-end">৳{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end fw-semibold">Delivery:</td>
                            <td class="text-end text-success">Free</td>
                        </tr>
                        <tr class="invoice-grand-total">
                            <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                            <td class="text-end fw-bold">৳{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="invoice-footer text-center mt-4">
                <p class="mb-1">Thank you for shopping with <strong>AmarMart</strong>!</p>
                <p class="text-muted small mb-0">For queries, contact: support@amarmart.com</p>
            </div>
        </div>

        <div class="invoice-actions text-center mt-4 no-print">
            <button class="btn btn-primary btn-lg me-3" onclick="window.print()" id="printInvoiceBtn">
                <i class="bi bi-printer me-2"></i>Print Invoice
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                <i class="bi bi-bag me-2"></i>Continue Shopping
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @media print {
        .no-print, .site-footer, #mainNavbar, .flash-alert { display: none !important; }
        .invoice-document { box-shadow: none !important; border: none !important; }
        body { font-size: 12pt; }
    }
</style>
@endpush
