<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchTripRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'from'            => 'required',
            'to'              => 'required',
            'date_of_journey' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'from.required'            => 'From location is required.',
            'to.required'              => 'Destination is required.',
            'date_of_journey.required' => 'Journey date is required.',
        ];
    }
}
