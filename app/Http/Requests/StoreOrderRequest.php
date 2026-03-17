<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('orders.place');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "products" => "required|array|min:1",
            "products.*.product_slug" => "required|exists:products,slug",
            "products.*.quantity" => "required|integer|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'The products field is required.',
            'products.array' => 'The products field must be an array.',
            'products.min' => 'At least one product must be included in the order.',
            'products.*.product_slug.required' => 'The product slug is required for each product.',
            'products.*.product_slug.exists' => 'The specified product does not exist.',
            'products.*.quantity.required' => 'The quantity is required for each product.',
            'products.*.quantity.integer' => 'The quantity must be an integer.',
            'products.*.quantity.min' => 'The quantity must be at least 1.',

        ];
    }
}
