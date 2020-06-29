<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CurrenciesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function wantsJson()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errorsValidate' => $validator->errors()], 400));
    }

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $regex = "/(^\d+\.?\d+$)|(^\d+$)/";
        $rules = [
            'buy' => ['required', 'regex:' . $regex],
            'sell' => ['required', 'regex:' . $regex]
        ];
        if ($this->getMethod() === 'POST') {
            $rules['currency'] = 'required|unique:App\Models\Currencies,currency';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'currency.required' => 'A currency is required',
            'currency.unique' => 'A currency is unique',
            'buy.required' => 'A buy is unique',
            'buy.regex' => 'A buy is format - int or float',
            'sell.regex' => 'A sell is format - int or float',
            'sell.required' => 'A sell is unique',
        ];
    }
}
