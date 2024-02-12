<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PracticeRequest extends FormRequest
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
        return [
            'name'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'telephone'     => 'required|numeric|digits_between:10,20',
            'manager_name'  => 'required|string|max:255',
            'status'        => 'required',
        ];
    }
}
