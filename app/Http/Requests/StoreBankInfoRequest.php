<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'name_bangla' => 'required|string|max:100',
            'account_type' => 'required|string|max:100',
            'branch' => 'required|string|max:100',
            'descriptions' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field must not exceed 100 characters.',
            'name_bangla.required' => 'The name_bangla field is required.',
            'name_bangla.string' => 'The name_bangla field must be a string.',
            'name_bangla.max' => 'The name_bangla field must not exceed 100 characters.',
            'account_type.required' => 'The account_type field is required.',
            'account_type.string' => 'The account_type field must be a string.',
            'account_type.max' => 'The account_type field must not exceed 100 characters.',
            'branch.required' => 'The branch field is required.',
            'branch.string' => 'The branch field must be a string.',
            'branch.max' => 'The branch field must not exceed 100 characters.',
            'descriptions.string' => 'The descriptions field must be a string.',
            'status.boolean' => 'The status field must be a boolean.',
        ];
    }
}
