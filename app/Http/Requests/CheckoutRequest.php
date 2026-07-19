<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'email'         => 'required|email|max:255',
            'address'       => 'required|string|max:1000',
            // Nullable so checkout still works if user denies geolocation
            'latitude'      => 'nullable|numeric|between:-90,90',
            'longitude'     => 'nullable|numeric|between:-180,180',
        ];
    }

    public function messages(): array
    {
        return [
            'customer_name.required' => 'Customer name is required.',
            'phone.required'         => 'Phone number is required.',
            'email.required'         => 'Email address is required.',
            'email.email'            => 'Please enter a valid email address.',
            'address.required'       => 'Delivery address is required.',
            'latitude.numeric'       => 'Latitude must be a valid number.',
            'latitude.between'       => 'Latitude must be between -90 and 90.',
            'longitude.numeric'      => 'Longitude must be a valid number.',
            'longitude.between'      => 'Longitude must be between -180 and 180.',
        ];
    }
}
