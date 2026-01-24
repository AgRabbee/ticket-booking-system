<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddDriverRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'email'      => 'required|string|email|unique:users,email',
            'phone'      => 'required|string',
            'password'   => 'required|string|min:6|confirmed',
            'nid'        => 'required|integer|max:99999999999',
            'terms'      => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'password.confirmed'  => 'Password confirmation does not match.',
            'terms.required'      => 'You must accept the terms.',
        ];
    }
}
