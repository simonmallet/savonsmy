<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'discount_from_retail' => 'required|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'validator.name_required',
            'email.required' => 'validator.email_required',
            'discount_from_retail.required' => 'validator.discount_from_retail_required',
            'discount_from_retail.numeric' => 'validator.discount_from_retail_numeric',
            'discount_from_retail.min' => 'validator.discount_from_retail_min',
            'discount_from_retail.max' => 'validator.discount_from_retail_max',
        ];
    }
}
