<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
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
            // 'name_bangla' => 'nullable|string',
            // 'size' => 'required|string',
            // 'description' => 'nullable|string',
            // 'logo' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            // 'name.string' => 'The name field must be a string',
            // 'name_bangla.string' => 'The name_bangla field must be a string',
            // 'size.required' => 'The size field is required',
            // 'size.string' => 'The size field must be a string',
            // 'description.string' => 'The description field must be a string',
        ];
    }
}
