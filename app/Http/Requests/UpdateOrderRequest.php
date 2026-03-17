<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  auth()->user()->can('orders.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "status" => ['required', 'in:processing,completed,cancelled'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'The status field is required.',
            'status.in' => 'The status must be one of the following:  processing, completed, cancelled.',
        ];
    }
}
