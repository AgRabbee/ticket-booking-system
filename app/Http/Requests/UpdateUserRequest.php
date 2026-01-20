<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'nid'        => 'required|digits_between:1,11',
        ];
    }

    /**
     * Custom validation error messages.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'First name is required.',
            'first_name.string'   => 'First name must be valid text.',
            'first_name.max'      => 'First name may not exceed 255 characters.',
            'last_name.required'  => 'Last name is required.',
            'last_name.string'    => 'Last name must be valid text.',
            'last_name.max'       => 'Last name may not exceed 255 characters.',
            'phone.required'      => 'Phone number is required.',
            'phone.string'        => 'Phone number must be valid text.',
            'phone.max'           => 'Phone number may not exceed 20 characters.',
            'nid.required'        => 'NID number is required.',
            'nid.digits_between'  => 'NID number must be between 1 and 11 digits.',
        ];
    }
}
