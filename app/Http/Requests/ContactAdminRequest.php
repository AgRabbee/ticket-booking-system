<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactAdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => 'required|string',
            'email'   => 'required|email',
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'Subject is required.',
            'email.required'   => 'Email is required.',
            'email.email'      => 'Invalid email format.',
        ];
    }
}
