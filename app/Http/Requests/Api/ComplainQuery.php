<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ComplainQuery extends FormRequest
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
            "limit" => 'int',
            "search" => 'string',
            /**
             * type complain
             * 
             * @example unit, lingkungan, lainnya
             */
            "type" => 'string',
            /**
             * status complain
             * 
             * @example request, finished
             */
            "status" => 'string',
            /**
             * Page number
             * 
             * @example 1
             */
            'page' => 'int',
        ];
    }
}
