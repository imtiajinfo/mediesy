<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemStoreMappingRequest extends FormRequest
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
            'item_id' => 'required|exists:item_infos,id',
            'store_id' => 'required|exists:stores,id',
            'descriptions' => 'nullable|string',
            'status' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'item_id.required' => 'The item ID is required.',
            'item_id.exists' => 'The selected item ID is invalid.',

            'store_id.required' => 'The store ID is required.',
            'store_id.exists' => 'The selected store ID is invalid.',

            'descriptions.string' => 'The descriptions must be a string.',

            'status.boolean' => 'The status must be a boolean value.',
        ];
    }

    protected function prepareForValidation()
    {
        // Example: Convert input to uppercase before validation
        $this->merge([
            'descriptions' => strtoupper($this->input('descriptions')),
        ]);
    }
}
