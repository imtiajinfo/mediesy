<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarrantyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assuming authorization logic is already handled elsewhere
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'store_id' => 'required|exists:stores,id',
            'customer_id' => 'required|exists:customers,id',
            'sells_id' => 'required|exists:sells,id',
            'item_id' => 'required|exists:item_infos,id',
            'type' => 'required|string',
            'duration' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'store_id.required' => 'Store ID is required.',
            'store_id.exists' => 'The selected store ID is invalid.',
            'customer_id.required' => 'Customer ID is required.',
            'customer_id.exists' => 'The selected customer ID is invalid.',
            'sells_id.required' => 'Sells ID is required.',
            'sells_id.exists' => 'The selected sells ID is invalid.',
            'item_id.required' => 'Item ID is required.',
            'item_id.exists' => 'The selected item ID is invalid.',
            'type.required' => 'Type is required.',
            'duration.required' => 'Duration is required.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Start date must be a valid date.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'End date must be a valid date.',
            'notes.string' => 'Notes must be a string.',
        ];
    }
}
