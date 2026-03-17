<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('manage-products');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'iamges' => 'required|array|min:1|max:4',
            'iamges.*' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_id' => 'required|exists:products,id',
        ];
    }
    public function messages(): array
    {
        return [
            'iamges.required' => 'At least one image is required.',
            'iamges.array' => 'The images must be an array.',
            'iamges.min' => 'At least one image is required.',
            'iamges.max' => 'You can upload a maximum of 4 images.',
            'iamges.*.required' => 'Each image is required.',
            'iamges.*.file' => 'Each item must be a file.',
            'iamges.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            'iamges.*.max' => 'Each image must not exceed 2048 kilobytes.',
            'product_id.required' => 'The product ID is required.',
            'product_id.exists' => 'The product ID does not exist.',
        ];
    }
}
