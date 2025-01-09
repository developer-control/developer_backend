<?php

namespace App\Http\Requests\Api;

use App\Models\UserUnit;
use Illuminate\Validation\Validator;
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
            'evidence_file' => 'string|nullable'
        ];
    }
    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $userUnit = UserUnit::where('project_unit_id', $this->input('project_unit_id'))
                    ->where('user_id', $this->user()->id)
                    ->where('status', '<>', 'failed')
                    ->first();
                if ($userUnit) {
                    $validator->errors()->add(
                        'project_unit_id',
                        'The unit has previously submitted a claim, please wait for the claim process to complete '
                    );
                }
            }
        ];
    }
}
