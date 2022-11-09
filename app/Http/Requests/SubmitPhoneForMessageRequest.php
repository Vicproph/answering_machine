<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitPhoneForMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $validIranianPhoneRule = function ($attribute, $value, $fail) {
            if (!preg_match('/^(98|0098|\+98|0)?9\d{9}$/u', $value))
                $fail(__('message.phone.format.invalid'));
        };
        return [
            'mobile' => ['required', 'string', $validIranianPhoneRule]
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'mobile' => $this->translateFromPersianToLatinNumerals($this->mobile)
        ]);
    }
    private function translateFromPersianToLatinNumerals(string $number)
    {
        return strtr($number, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9'
        ]);
    }
}
