<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class DetailBillQuery extends FormRequest
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
            /**
             * month berisi date format month
             * @example 01
             */
            'month' => ['string', 'required'],
            /**
             * year berisi date format year
             * @example 2025
             */
            'year' => ['string', 'required'],
            'invoice_code' => ['nullable', 'string'],
        ];
    }
}
