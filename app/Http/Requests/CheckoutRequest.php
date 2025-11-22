<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization logic for checkout.
        // For now, allow all requests; later, ensure user is logged in or has a valid session.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Shipping Address Validation (assuming these fields are submitted as part of the request)
            'shipping_address.address_line_1' => ['required', 'string', 'max:255'],
            'shipping_address.address_line_2' => ['nullable', 'string', 'max:255'],
            'shipping_address.city' => ['required', 'string', 'max:255'],
            'shipping_address.state' => ['required', 'string', 'max:255'],
            'shipping_address.postal_code' => ['required', 'string', 'max:20'],
            'shipping_address.country' => ['required', 'string', 'max:255'],
            
            // Payment Method Validation
            'payment_method' => ['required', 'string', 'in:stripe,cod,paypal'], // Example payment methods
            
            // Grand Total (might be calculated server-side, but good to have a client-side check if passed)
            'grand_total' => ['required', 'integer', 'min:0'],

            // Additional fields that might come from the cart or user
            // 'cart_id' => ['required', 'exists:carts,id'], // If we pass cart_id explicitly
            // 'user_id' => ['nullable', 'exists:users,id'], // If user is logged in
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'shipping_address.address_line_1.required' => 'Address Line 1 is required.',
            'shipping_address.city.required' => 'City is required.',
            'shipping_address.state.required' => 'State is required.',
            'shipping_address.postal_code.required' => 'Postal Code is required.',
            'shipping_address.country.required' => 'Country is required.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Selected payment method is invalid.',
            'grand_total.required' => 'Grand total is missing.',
            'grand_total.min' => 'Grand total must be a positive value.',
        ];
    }
}
