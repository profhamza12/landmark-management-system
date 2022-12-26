<?php

namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'vendor.name.*' => 'required|min:5|max:100',
            'email' => 'required|email|unique:vendors,email,' . $this->id,
            'phone' => 'required|min:8|regex:/^[0-9]+$/|unique:vendors,phone,' . $this->id,
            'password' => 'required|min:8',
            'vendor.address.*' => 'required|min:5',
            'photo' => 'required|mimes:jpg,jpeg,png',
            'invoice_type' => 'required'
        ];
        if (in_array(request()->method(), ['PUT', 'PATCH']))
        {
            $rules['password'] = 'sometimes|nullable|min:8';
            $rules['photo'] = 'sometimes|nullable|mimes:jpg,jpeg,png';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => trans('content.requiredMsg'),
            'unique' => trans('content.uniqueMsg'),
            'email' => trans('content.mailMsg'),
            'vendor.name.*.min' => trans('content.vendornamemin'),
            'vendor.name.*.max' => trans('content.vendornamemax'),
            'phone.min' => trans('content.phonemin'),
            'phone.regex' => trans('content.phoneregex'),
            'password.min' => trans('content.vendorpassmin'),
            'vendor.address.*.min' => trans('content.addressmin'),
            'mimes' => trans('content.mimesMsg'),
        ];
    }

}
