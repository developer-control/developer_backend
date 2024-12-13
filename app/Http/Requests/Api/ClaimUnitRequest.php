<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ClaimUnitRequest extends FormRequest
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
            'developer_id' => 'required',
            'project_id' => 'required',
            'project_area_id' => 'required',
            'project_bloc_id' => 'required',
            'project_unit_id' => 'required',
            'ownership_unit_id' => 'required',
            'city_id' => 'required',
            /**
             * File url evidence
             * 
             * @example ownership-units/evidence/hdsfgkjgsjfg.png
             */
            'evidence_file' => 'string'
        ];
    }
}
