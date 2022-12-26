<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'client.name.*' => 'required|min:2',
            'email' => 'required|email|unique:clients,email,' . $this->id,
            'phone' => 'required|min:8|regex:/^[0-9]+$/|unique:clients,phone,' . $this->id,
            'client.address.*' => 'required|min:4',
            'group_id' => 'required',
            'invoice_type' => 'required'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => trans('content.requiredMsg'),
            'unique' => trans('content.uniqueMsg'),
            'email' => trans('content.mailMsg'),
            'client.name.*.min' => trans('content.clientnamemin'),
            'phone.min' => trans('content.phonemin'),
            'phone.regex' => trans('content.phoneregex'),
            'client.address.*.min' => trans('content.clientaddressmin'),
        ];
    }
}
