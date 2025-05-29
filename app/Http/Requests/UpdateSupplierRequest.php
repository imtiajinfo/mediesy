<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSupplierRequest extends FormRequest
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
        $supplierId = $this->route('supplier');
        return [
            'name'                 => 'nullable|string',
            'slug'                 => 'nullable',
            'phone'                => 'nullable|string',
            // 'email'                => 'nullable|email',
            'gst_number'           => 'nullable|numeric',
            'tax_number'           => 'nullable|numeric',
            'country'              => 'nullable|string',
            'state'                => 'nullable|string',
            'city'                 => 'nullable|string',
            'postcode'             => 'nullable|string',
            'address'              => 'nullable|string',
            'company_name'         => [
                'required',
                'string',
                Rule::unique('suppliers', 'company_name')->ignore($supplierId),
            ],
            'company_tin_number'   => 'nullable|string',
            'supplier_destination' => 'nullable|string',
            'brand'                => 'nullable|string',
        ];
    }
}
