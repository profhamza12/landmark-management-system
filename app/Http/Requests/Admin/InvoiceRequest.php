<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'store' => 'required',
            'branch' => 'required',
            'client' => 'required',
            'invoice_type' => 'required',
            'store_quantity.*.item' => 'required',
            'store_quantity.*.unit' => 'required',
            'store_quantity.*.quantity' => 'required',
            'remaining_amount' => "required",
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => trans('content.requiredMsg'),
        ];
    }
}
