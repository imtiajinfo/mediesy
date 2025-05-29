<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseOrdersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        // Add authorization logic if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'required|integer',
            'total_purchase_qty' => 'nullable|integer',
            'purchase_qty' => 'nullable',
            'purchased_by' => 'required|integer',
            'product_id' => 'required',
            'po_date' => 'required|date',
            'challan_number' => 'required|integer',
            'remarks' => 'nullable',
            'items.*.product_id' => 'required|integer',
            'items.*.purchase_qty' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'items.*.total_amount' => 'required|numeric',
            'items.*.is_received' => 'required|boolean',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'supplier_id.required' => 'The supplier ID field is required.',
            'supplier_id.integer' => 'The supplier ID must be an integer.',
            'total_purchase_qty.integer' => 'The total purchase quantity must be an integer.',
            'purchased_by.required' => 'The purchaser ID field is required.',
            'purchased_by.integer' => 'The purchaser ID must be an integer.',
            'product_id.required' => 'The product ID field is required.',
            'po_date.required' => 'The purchase order date field is required.',
            'po_date.date' => 'The purchase order date must be a valid date.',
            'challan_number.required' => 'The challan number field is required.',
            'challan_number.integer' => 'The challan number must be an integer.',
            'items.*.product_id.required' => 'The product ID in items array is required.',
            'items.*.product_id.integer' => 'The product ID in items array must be an integer.',
            'items.*.purchase_qty.required' => 'The purchase quantity in items array is required.',
            'items.*.purchase_qty.integer' => 'The purchase quantity in items array must be an integer.',
            'items.*.amount.required' => 'The amount in items array is required.',
            'items.*.amount.numeric' => 'The amount in items array must be a number.',
            'items.*.total_amount.required' => 'The total amount in items array is required.',
            'items.*.total_amount.numeric' => 'The total amount in items array must be a number.',
            'items.*.is_received.required' => 'The is_received field in items array is required.',
            'items.*.is_received.boolean' => 'The is_received field in items array must be a boolean value.',
        ];
    }
}
