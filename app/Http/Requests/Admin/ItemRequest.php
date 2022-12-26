<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'item.name.*' => 'required|min:3|unique_translation:items,name,' . $this->id,
            'item_unit_price.*.unit' => 'required',
            'item_unit_price.*.count' => 'required',
            'item_unit_price.*.selling_price' => 'required',
            'item_unit_price.*.purchasing_price' => 'required',
            'item_unit_price.*.wholesale_price' => 'required',
            'store_quantity.*.branch' => 'required',
            'store_quantity.*.store' => 'required',
            'store_quantity.*.unit' => 'required',
            'store_quantity.*.quantity' => 'required',
            'maincat_id' => 'required',
            'coin' => 'required',
            'photo' => 'required|mimes:jpg,jpeg,png'
        ];
        if (in_array(request()->method(), ['PUT', 'PATCH']))
        {
            $rules['photo'] = 'sometimes|nullable|mimes:jpg,jpeg,png';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => trans('content.requiredMsg'),
            'unique' => trans('content.uniqueMsg'),
            'item.*.name.min' => trans('content.itemnamemin'),
            'mimes' => trans('content.mimesMsg'),
        ];
    }
}
