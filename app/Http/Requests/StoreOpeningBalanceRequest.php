<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpeningBalanceRequest extends FormRequest
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
            'supplier_id' => 'nullable|integer',
            'total_purchase_qty' => 'nullable|integer',
            'purchase_qty' => 'nullable',
            'purchased_by' => 'required|integer',
            'product_id' => 'required',
            'po_date' => 'required|date',
            'remarks' => 'nullable',
            'items.*.product_id' => 'required|integer',
            'items.*.purchase_qty' => 'required|integer',
            'items.*.amount' => 'required|numeric',
        ];
    }
}
