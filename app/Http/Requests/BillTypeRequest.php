<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BillTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {

        $this->merge([
            'is_edit' => $this->is_edit ?? 0,
            'is_premium' => $this->is_premium ?? 0,
            'with_start_value' => $this->with_start_value ?? 0
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'
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
