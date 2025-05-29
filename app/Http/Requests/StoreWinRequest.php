<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|exists:rooms,id|max:255',
        ];
    }

    public function messages()
    {
        return [
            'id.integer' => 'The room id must be a integer.',
            'id.required' => 'The room id required.',
            'id.max' => 'The room id may not be greater than :max characters.',
        ];
    }
}
