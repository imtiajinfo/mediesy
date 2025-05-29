<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMoneyLendingRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'name_bangla' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'nid' => 'required|integer',
            'country' => 'required|string',
            'division' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'Area' => 'required|string',
            'postcode' => 'required|string',
            'parent_address' => 'required|string',
            'permanent_address' => 'required|string',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'to_amount' => 'required|numeric',
            'recv_amount' => 'nullable|numeric',
            'due_amount' => 'nullable|numeric',
            'monthly_profit' => 'nullable|numeric',
            'is_closed' => 'nullable|boolean',
        ];
    }
}
