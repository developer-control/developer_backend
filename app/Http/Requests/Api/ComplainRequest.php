<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ComplainRequest extends FormRequest
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
    public function rules()
    {
        return array_merge([
            'developer_id' => ['required', 'int'],

            /**
             * required jika type adalah lingkungan
             * 
             */
            'project_id' => ['int'],
            /**
             * required jika type adalah lingkungan
             * 
             */
            'project_area_id' => ['int'],
            /**
             * required jika type adalah unit
             * 
             */
            'project_unit_id' => ['int'],
            'title' => ['required', 'string'],
            'images' => 'array|nullable',
            /**
             * required jika type adalah lingkungan atau lainnya
             * 
             */
            'address' => 'string|nullable',
            'description' => ['required', 'string'],
            'type' => ['required', 'string'],
        ], $this->conditionalRules());
    }

    private function conditionalRules()
    {
        switch ($this->type) {
            case 'unit':
                return [
                    'project_unit_id' => ['required', 'int']
                ];
            case 'lingkungan':
                return [
                    'project_id' => ['required', 'int'],
                    'address' => ['required', 'string'],
                    'project_area_id' => ['required', 'int']
                ];
            default:
                return ['address' => ['required', 'string']];
        }
    }
}
