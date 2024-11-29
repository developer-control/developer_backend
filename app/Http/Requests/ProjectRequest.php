<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectRequest extends FormRequest
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
        if (auth()->user()->hasRole('superadmin')) {
            return [
                'name' => 'required',
                'developer_id' => 'required',
                'city_id' => 'required',
            ];
        }
        return [
            'name' => 'required',
            'developer_id' => 'required',
            'city_id' => 'required',
        ];
    }
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        // $exception = $validator->getException();
        // Ambil pesan error pertama
        $firstError = collect($validator->errors()->all())->first();
        toast($firstError, 'error');
        // Kirim respon redirect dengan pesan error untuk toast
        throw new HttpResponseException(
            redirect()->back()->withInput()->withErrors($validator)
        );
    }
}
