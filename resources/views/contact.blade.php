@extends('layouts.app')

@section('title', 'Contact — AmarMart')

@section('content')
<section class="products-section pt-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <h1 class="page-title mb-3"><i class="bi bi-envelope me-2"></i>Contact Us</h1>
                <p class="text-muted">Have a question? Send us a message and we will get back to you.</p>
                <ul class="list-unstyled mt-4">
                    <li class="mb-2"><i class="bi bi-envelope-fill me-2 text-primary"></i>support@amarmart.com</li>
                    <li class="mb-2"><i class="bi bi-telephone-fill me-2 text-primary"></i>+880 1700-000000</li>
                    <li class="mb-2"><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Dhaka, Bangladesh</li>
                </ul>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="message">Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" rows="4"
                                          class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-1"></i>Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
