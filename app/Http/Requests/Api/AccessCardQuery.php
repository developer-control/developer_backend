<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AccessCardQuery extends FormRequest
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
            "limit" => 'int|nullable',
            "search" => 'string|nullable',
            "developer_id" => 'int|nullable',
            "project_unit_id" => 'int|nullable',
            /**
             * Page number
             * 
             * @example 1
             */
            'page' => 'int|nullable',
        ];
    }
}
