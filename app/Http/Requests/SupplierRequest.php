<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier');

        $rules = [
            'name'          => 'required',
            'telephone'     => 'required|numeric',
            'account_number'  => 'required',
            'status'        => 'required',
            'email' => [
                'required', // Make the email field optional
                'email',  // Allow null values
                Rule::unique('suppliers', 'email')->ignore($supplierId),
            ],
        ];

        return $rules;
    }
}
