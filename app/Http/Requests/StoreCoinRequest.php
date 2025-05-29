<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoinRequest extends FormRequest
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
            'user_id' => 'nullable|string|exists:users,id|max:255',
            'desk_id.*' => 'required',
            'coin.*' => 'required',
            'active_status' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'room_name.string' => 'The room name must be a string.',
            'room_name.unique' => 'The room name has already been taken.',
            'room_name.max' => 'The room name may not be greater than :max characters.',
            'creating_time.date_format' => 'The creating time must be in the format HH:MM:SS.',
            'active_status.boolean' => 'The active status must be either true or false.',
        ];
    }
}
