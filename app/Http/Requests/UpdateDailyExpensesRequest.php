<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyExpensesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'expense_name' => 'required|string',
            'expense_group' => 'required|string',
            'company' => 'required|string',
            'store' => 'required|string',
            'expense_date' => 'required|date',
            'approved_status' => 'required|string',
            'deleted_at' => 'nullable',
            'amount' => 'required',
        ];
    }
}
