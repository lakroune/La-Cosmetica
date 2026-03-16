<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreImageRequest extends FormRequest
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
            'url' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'url.required' => 'The image URL is required.',
            'url.string' => 'The image URL must be a string.',
            'url.max' => 'The image URL may not be greater than 255 characters.',
            'product_id.required' => 'The product ID is required.',
            'product_id.exists' => 'The specified product does not exist.',
        ];
    }
}
