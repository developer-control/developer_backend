<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        $rule = [
            'name' => 'required',
            'email' => 'required',
            'identity_number' => 'required',
            'id_card_image' => 'required',
        ];

        if ($this->user()->hasRole('superadmin')) {
            $rule['developer_id'] = 'required';
        }
        if (($this->routeIs('user.store'))) {
            $rule['password'] = 'required';
            $rule['role'] = 'required';
        }
        return $rule;
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
