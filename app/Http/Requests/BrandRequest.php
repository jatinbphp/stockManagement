<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }

    
    public function rules(): array
    {
        $rules = [
            'name'          => 'required',
            'image'         => 'mimes:jpeg,jpg,png,bmp',
            'status'        => 'required',
            'supplier_id'   => 'required',
        ];
/*
        // Check if it's an edit scenario
        if ($this->isMethod('patch')) {
            $rules['image'] = 'mimes:jpeg,jpg,png,bmp';
        }*/

        return $rules;
    }
}
