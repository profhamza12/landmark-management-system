<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'store.name.*' => 'required|min:2|unique_translation:stores,name,' . $this->id,
            'store.address.*' => 'required|min:4',
            'phone' => 'required|min:8|regex:/^[0-9]+$/',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => trans('content.requiredMsg'),
            'unique' => trans('content.uniqueMsg'),
            'store.name.*.min' => trans('content.storenamemin'),
            'store.address.*.min' => trans('content.storeaddressmin'),
            'phone.min' => trans('content.storephonemin'),
            'phone.regex' => trans('content.storephoneregex'),
        ];
    }
}
