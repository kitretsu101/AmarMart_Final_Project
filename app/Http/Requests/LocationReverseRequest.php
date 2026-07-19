<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationReverseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }

    public function messages(): array
    {
        return [
            'latitude.required'  => 'Latitude is required.',
            'latitude.numeric'   => 'Latitude must be a valid number.',
            'latitude.between'   => 'Latitude must be between -90 and 90.',
            'longitude.required' => 'Longitude is required.',
            'longitude.numeric'  => 'Longitude must be a valid number.',
            'longitude.between'  => 'Longitude must be between -180 and 180.',
        ];
    }
}
