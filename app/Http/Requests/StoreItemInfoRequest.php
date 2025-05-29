<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemInfoRequest extends FormRequest
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
            // 'category_id' => 'required|integer',
            // 'brand_id' => 'required',
            'color_id' => 'nullable',
            'size_id' => 'nullable',
            'product_type' => 'required',
            'slug' => [
                'required',
                'string',
                'max:120',
                Rule::unique('item_infos')->ignore($this->item_info),
            ],
            'min_qty' => 'nullable|numeric|min:1',
            'trans_uom' => 'nullable|integer',
            'stock_uom' => 'nullable|integer',
            'sales_uom' => 'nullable|integer',
            'weight' => 'nullable',
            'product_id' => 'nullable|unique:item_infos,id',
            'name' => 'required|string|unique:item_infos,name',
            'name_bangla' => 'nullable',
            'published_price' => 'nullable|numeric',
            'sell_price' => 'nullable|numeric',
            'published' => 'nullable|numeric',
            'purchase_price' => 'nullable|numeric',
            'discount_amount' => 'nullable',
            'discount_type' => 'nullable|integer',
            'current_stock' => 'nullable',
            'thumbnail' => 'nullable',
            'attachment' => 'nullable',
            'status' => 'nullable',
            'stock_status' => 'nullable',
            // 'sub_title' => [
            //     'required',
            //     'string',
            //     'max:120',
            //     Rule::unique('item_infos')->ignore($this->item_info),
            // ],
            'summary' => 'nullable',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name),
        ]);
    }
}
