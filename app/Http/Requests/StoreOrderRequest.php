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
            "total_price" => ['required', 'numeric', 'min:0'],
            "status" => ['required', 'in:pending,processing,completed,cancelled'],
            "user_id" => ['required', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'total_price.required' => 'The total price is required.',
            'total_price.numeric' => 'The total price must be a number.',
            'total_price.min' => 'The total price must be at least 0.',
            'status.required' => 'The order status is required.',
            'status.in' => 'The order status must be one of the following: pending, processing, completed, cancelled.',
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user does not exist.',
        ];
    }
}
