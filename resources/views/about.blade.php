@extends('layouts.app')

@section('title', 'About Us — AmarMart')

@section('content')
<section class="products-section pt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="page-title mb-3"><i class="bi bi-info-circle me-2"></i>About AmarMart</h1>
                <p class="lead text-muted">
                    AmarMart is a mini e-commerce management system built as a university Web Programming project.
                </p>
                <p>
                    We offer electronics, fashion, and everyday essentials with a simple shopping experience —
                    browse products, add them to your cart, checkout with location detection, and receive an instant invoice.
                </p>
                <div class="row g-3 mt-3">
                    <div class="col-md-4">
                        <div class="card h-100 text-center p-3">
                            <i class="bi bi-shield-check display-6 text-primary"></i>
                            <h5 class="mt-2">Secure</h5>
                            <p class="small text-muted mb-0">CSRF, validation &amp; protected admin routes</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center p-3">
                            <i class="bi bi-lightning-charge display-6 text-primary"></i>
                            <h5 class="mt-2">Fast</h5>
                            <p class="small text-muted mb-0">AJAX cart, live search &amp; responsive UI</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 text-center p-3">
                            <i class="bi bi-heart display-6 text-primary"></i>
                            <h5 class="mt-2">Simple</h5>
                            <p class="small text-muted mb-0">Beginner-friendly Laravel MVC architecture</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
