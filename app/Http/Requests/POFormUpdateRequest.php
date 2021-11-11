<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class POFormUpdateRequest extends FormRequest
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
            'category.*.price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return [
            'category.*.price.regex' => "Le montant est invalide. Formats acceptés: 5 ou 5.5 ou 5.55",
        ];
    }
}
