<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'project_unit_id' => 'project unit',
            'bill_type_id' => 'type tagihan',
            'usage_period_at' => 'periode penggunaan',
            'billed_at' => 'bulan penagihan',
            'value' => 'nilai tagihan'
        ];
    }
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {


        $this->merge([
            'usage_period_at' => $this->usage_period_at ? $this->usage_period_at . '-01' : null,
            'billed_at' => $this->billed_at ? $this->billed_at . '-01' : null,
            'total' => $this->sumTotal() ?? $this->total
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $main_rules = [
            'project_unit_id' => 'required',
            'bill_type_id' => 'required',
            'usage_period_at' => 'required',
            'billed_at' => 'required',
            'value' => 'required',
            'total' => 'required',
        ];
        return $main_rules;
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

    public function sumTotal()
    {
        $total = $this->value + $this->tax + $this->penalty;
        $decrease = $this->discount + $this->bill_release + $this->penalty_release + $this->paid;
        return $total - $decrease;
    }
}
