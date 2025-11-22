<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Will implement proper authorization later
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'], // Stored as unsignedInteger (cents)
            'sale_price' => ['nullable', 'integer', 'min:0', 'lt:price'], // Must be less than regular price
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'is_active' => ['boolean'],
            'image_path' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'], // Max 2MB image
        ];
    }
}
