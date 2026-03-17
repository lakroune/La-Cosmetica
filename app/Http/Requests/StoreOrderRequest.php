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
        return true;
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
            "products.*.product_id" => "required|exists:products,id",
            "products.*.quantity" => "required|integer|min:1",
        ];
    }

    public function messages(): array
    {
        return [
            "products.required" => "The products field is required.",
            "products.array" => "The products field must be an array.",
            "products.min" => "At least one product is required.",
            "products.*.product_id.required" => "Each product must have a product ID.",
            "products.*.product_id.exists" => "The specified product does not exist.",
            "products.*.quantity.required" => "Each product must have a quantity.",
            "products.*.quantity.integer" => "The quantity must be an integer.",
            "products.*.quantity.min" => "The quantity must be at least 1.",
            
        ];
    }
}
