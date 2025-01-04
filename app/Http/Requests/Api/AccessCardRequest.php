<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AccessCardRequest extends FormRequest
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
            'developer_id' => ['required', 'int'],
            'project_unit_id' => ['int', 'required'],
            'name' => ['required', 'string'],
            'vehicle_number' => 'string|nullable',
            /**
             * start date tanggal Y-m-d
             */
            'start_date' => ['string', 'required'],
            /**
             * start time tanggal H:i:s
             */
            'start_time' => ['string', 'required'],
            /**
             * end date tanggal Y-m-d
             */
            'end_date' => ['string', 'required'],
            /**
             * end time tanggal H:i:s
             */
            'end_time' => ['string', 'required']
        ];
    }
}
