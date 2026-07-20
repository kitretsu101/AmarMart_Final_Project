@extends('layouts.app')

@section('title', 'Contact — AmarMart')

@section('content')
@php
    $contactDetails = [
        ['icon' => 'bi-envelope-fill', 'text' => 'support@amarmart.com'],
        ['icon' => 'bi-telephone-fill', 'text' => '+880 1700-000000'],
        ['icon' => 'bi-geo-alt-fill', 'text' => 'Dhaka, Bangladesh'],
    ];

    $formFields = [
        ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
        ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
        ['name' => 'message', 'label' => 'Message', 'type' => 'textarea', 'required' => true],
    ];
@endphp

<section class="products-section pt-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <h1 class="page-title mb-3"><i class="bi bi-envelope me-2"></i>Contact Us</h1>
                <p class="text-muted">Have a question? Send us a message and we will get back to you.</p>
                <ul class="list-unstyled mt-4">
                    @foreach ($contactDetails as $detail)
                        <li class="mb-2">
                            <i class="bi {{ $detail['icon'] }} me-2 text-primary"></i>{{ $detail['text'] }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('contact.submit') }}" method="POST">
                            @csrf
                            @foreach ($formFields as $field)
                                <div class="mb-3">
                                    <label class="form-label" for="{{ $field['name'] }}">
                                        {{ $field['label'] }}
                                        @if ($field['required'])
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>

                                    @if ($field['type'] === 'textarea')
                                        <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}" rows="4"
                                                  class="form-control @error($field['name']) is-invalid @enderror" required>{{ old($field['name']) }}</textarea>
                                    @else
                                        <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
                                               class="form-control @error($field['name']) is-invalid @enderror"
                                               value="{{ old($field['name']) }}" @if ($field['required']) required @endif>
                                    @endif

                                    @error($field['name'])<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            @endforeach

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
