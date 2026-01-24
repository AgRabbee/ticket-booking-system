<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company_name'        => 'required|string|max:255',
            'company_description' => 'required|string',
            'address'             => 'required|string',
            'reg_no'              => 'required|string|max:100',
            'tin_no'              => 'required|integer',
            'company_image'       => 'nullable|image|max:1999',
            'trade'               => 'required|image|max:1999',
            'vat'                 => 'required|image|max:1999',
        ];
    }

    public function messages(): array
    {
        return [
            'company_name.required' => 'Company name is required.',
            'trade.required'        => 'Trade license image is required.',
            'vat.required'          => 'VAT certificate image is required.',
            'tin_no.integer'        => 'TIN number must be numeric.',
        ];
    }
}
