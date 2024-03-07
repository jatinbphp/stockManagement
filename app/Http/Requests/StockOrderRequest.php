<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'brand_id'      => 'required|exists:brands,id',
            'supplier_id'   => 'required|exists:suppliers,id',
            'practice_id'   => 'required|exists:practices,id',
            'order_copy'    => 'required|file|mimes:jpg,pdf,doc,docx,png|max:10240', 
        ];

        if ($this->isMethod('patch')) {
            $rules['order_copy'] = 'nullable|file|mimes:pdf,doc,docx,png|max:10240';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'brand_id.required'     => "The brand field is required.",
            'supplier_id.required'  => "The supplier field is required.",
            'practice_id.required'  => "The practice field is required.",
        ];
    }
}
