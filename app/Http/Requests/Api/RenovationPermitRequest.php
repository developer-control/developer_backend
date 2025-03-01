<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RenovationPermitRequest extends FormRequest
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
            'title' => 'required',
            'id_card_photo' => 'required',
            'unit_layout' => 'string|nullabe',
            'neighborhood_certificate' => 'string|nullable',
            'power_of_attorney' => 'string|nullable',
            'permit_letter' => 'string|nullable',
            'deposit_statement' => 'string|nullable',
            'neighbor_information' => 'string|nullable'
        ];
    }
}
