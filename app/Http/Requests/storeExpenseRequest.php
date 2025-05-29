<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
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
            'name' => 'required|string',
            'name_bangla' => 'nullable|string',
            'descriptions' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            'name.string' => 'The name field must be a string',
            'name_bangla.string' => 'The name_bangla field must be a string',
            'descriptions.string' => 'The descriptions field must be a string',
            'status.string' => 'The status field must be a string',
        ];
    }
}
