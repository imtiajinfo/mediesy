<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization logic if needed
    }

    public function rules()
    {
        return [
            'name_english' => 'required|string',
            'name_bangla' => 'nullable|string',
            'code' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name_english.required' => 'The name_english field is required',
            'name_english.string' => 'The name_english field must be a string',
            'name_bangla.required' => 'The name_bangla field is required',
            'code.string' => 'The code field must be a string',
            'description.string' => 'The description field must be a string',
        ];
    }
}
