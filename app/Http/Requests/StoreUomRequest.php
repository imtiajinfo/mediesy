<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'uom_set_id' => 'nullable|string|exists:uomsets,id',
            'uom_short_code' => 'required|string',
            'uom_desc' => 'nullable',
            'local_desc' => 'nullable',
            'relative_factor' => 'nullable',
            'fraction_allow' => 'nullable',
            'is_active' => 'nullable',
            'created_by' => 'nullable',
            'updated_by' => 'nullable',
        ];
    }
}
