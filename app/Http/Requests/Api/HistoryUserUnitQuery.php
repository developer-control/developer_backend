<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class HistoryUserUnitQuery extends FormRequest
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
            'search' => 'string',
            'limit' => 'int',
            /**
             * status kepemilikan
             * @example request, claimed, reject
             */
            'status' => 'string',
            /**
             * Page number
             * 
             * @example 1
             */
            'page' => 'int',
        ];
    }
}
