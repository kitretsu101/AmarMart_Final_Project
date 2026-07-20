<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Product name is required.',
            'price.required' => 'Price is required.',
            'price.numeric'  => 'Price must be a valid number.',
            'stock.required' => 'Stock quantity is required.',
            'stock.integer'  => 'Stock must be a whole number.',
            'image.image'    => 'The uploaded file must be an image.',
            'image.max'      => 'Image size must not exceed 2MB.',
        ];
    }
}
