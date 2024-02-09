<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product');

        $rules = [
            'category_id' => 'required',
            'product_name' => 'required',
            'description' => 'required',
            'sku' => 'required|unique:products',
            'price' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'status' => 'required',
            'sku' => [
                'required',
                Rule::unique('products', 'sku')->ignore($productId),
            ],
        ];

        return $rules;
    }
}
