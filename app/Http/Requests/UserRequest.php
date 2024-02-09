<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');

        $rules = [
            'name' => 'required',
            'password' => 'confirmed|min:6',
            'phone' =>'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png,bmp',
            'status' => 'required',
            'email' => [
                'required', // Make the email field optional
                'email',  // Allow null values
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];

        // Check if it's an edit scenario
        if ($this->isMethod('patch')) {
            $rules['password'] = 'nullable|confirmed|min:6';
            $rules['image'] = 'mimes:jpeg,jpg,png,bmp';
        }

        return $rules;
    }
}
