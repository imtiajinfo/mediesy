<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
            'name_bangla' => 'required|string',
            'descriptions' => 'required|string',
            'status' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            'name.string' => 'The name field must be a string',
            'name_bangla.required' => 'The name_bangla field is required',
            'name_bangla.string' => 'The name_bangla field must be a string',
            'descriptions.required' => 'The descriptions field is required',
            'descriptions.string' => 'The descriptions field must be a string',
            'status.string' => 'The status field must be a string',
        ];
    }
}
