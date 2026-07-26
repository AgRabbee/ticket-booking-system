<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompletePaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'phone'  => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'f_name.required' => 'First name is required.',
            'l_name.required' => 'Last name is required.',
            'phone.required'  => 'Phone number is required.',
        ];
    }
}
