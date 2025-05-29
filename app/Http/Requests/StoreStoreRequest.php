<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email',
            'country' => 'nullable|string',
            'district' => 'nullable|string',
            'upazila' => 'nullable|string',
            'postcode' => 'nullable|string',
            'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'phone.string' => 'The phone must be a string.',
            'phone.max' => 'The phone must not be more than :max characters.',
            'email.required' => 'The email is required.',
            'email.email' => 'Please enter a valid email address.',
            'country.string' => 'The country must be a string.',
            'district.string' => 'The district must be a string.',
            'upazila.string' => 'The upazila must be a string.',
            'postcode.string' => 'The postcode must be a string.',
            'address.string' => 'The address must be a string.',
        ];
    }

    protected function prepareForValidation()
    {
        // Additional logic to prepare data before validation, if needed
        $this->merge([
            'name' => ucfirst($this->input('name')), // Capitalize the first letter of the name
            'postcode' => strtoupper($this->input('postcode')), // Convert postcode to uppercase
            // Add more data modifications as needed
        ]);
    }
}
