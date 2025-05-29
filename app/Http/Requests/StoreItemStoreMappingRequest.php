<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Models\ItemStoreMapping;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemStoreMappingRequest extends FormRequest
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
        // Call prepareValidation() method to prepare validation rules
        $this->prepareValidation();

        return [
            'item_id' => 'required|exists:item_infos,id',
            'store_id' => 'required|exists:stores,id',
            'descriptions' => 'nullable|string',
            'status' => 'boolean',
            // Add the unique_rule field to the rules array
            'unique_rule' => 'boolean', // Assuming this will be used to check uniqueness
        ];
    }

    protected function prepareValidation()
    {
        // Retrieve the route parameter 'id'
        $itemId = $this->route('id');

        // Merge the unique_rule field into the request data
        $this->merge([
            'unique_rule' => ItemStoreMapping::where('item_id', $this->input('item_id'))
                ->where('store_id', $this->input('store_id'))
                ->where('id', '!=', $itemId) // Exclude current record if updating
                ->exists(), // Returns true if a record with the same item_id and store_id exists
        ]);
    }




    public function messages()
    {
        return [
            'item_id.required' => 'The item ID field is required.',
            'item_id.exists' => 'The selected item ID is invalid.',
            'store_id.required' => 'The store ID field is required.',
            'store_id.exists' => 'The selected store ID is invalid.',
            'descriptions.string' => 'The descriptions must be a string.',
            'status.boolean' => 'The status field must be true or false.',
            'unique_rule.boolean' => 'The combination of item ID and store ID already exists.',
        ];
    }
}
