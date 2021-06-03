<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewCustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:5', 'confirmed'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
