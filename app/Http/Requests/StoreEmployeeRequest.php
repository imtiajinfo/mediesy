<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'store_id' => 'required|integer',
            'role' => 'required|string|max:50',
            'name' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:employees,email',
            'password' => 'nullable|string',
            'country' => 'nullable|string',
            'district' => 'nullable|string',
            'upazila' => 'nullable|string',
            'postcode' => 'nullable|string',
            'address' => 'nullable|string',
            'nid' => 'nullable|string',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image', // Assuming image is uploaded file
            'nid_font' => 'nullable|image', // Assuming image is uploaded file
            'nid_back' => 'nullable|image', // Assuming image is uploaded file
            'reference_details' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'store_id.required' => 'The store ID is required.',
            'store_id.integer' => 'The store ID must be an integer.',
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'role.required' => 'The role is required.',
            'role.string' => 'The role must be a string.',
            'role.max' => 'The role must not be more than :max characters.',
            'phone.string' => 'The phone must be a string.',
            'phone.max' => 'The phone must not be more than :max characters.',
            'email.required' => 'The email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.string' => 'The password must be a string.',
            'country.string' => 'The country must be a string.',
            'district.string' => 'The district must be a string.',
            'upazila.string' => 'The upazila must be a string.',
            'postcode.string' => 'The postcode must be a string.',
            'address.string' => 'The address must be a string.',
            'nid.string' => 'The NID must be a string.',
            'salary.numeric' => 'The salary must be a number.',
            'image.image' => 'The image must be an image file.',
            'nid_font.image' => 'The NID front must be an image file.',
            'nid_back.image' => 'The NID back must be an image file.',
            'reference_details.string' => 'The reference details must be a string.',
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
