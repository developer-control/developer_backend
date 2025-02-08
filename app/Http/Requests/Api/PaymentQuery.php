<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PaymentQuery extends FormRequest
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
             * Page number
             * 
             * @example 1
             */
            'page' => 'int|nullable',
            "limit" => 'int|nullable',
            "search" => 'string|nullable',
            /**
             * Status dari sebuah transaksi
             * 
             * @example request, cancel, reject, paid
             */
            "status" => 'string|nullable',

        ];
    }
}
