<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            'lang.name.*' => 'required',
            'lang.abbr' => 'required|max:20|unique:languages,abbr,' . $this->id,
            'lang.direction' => 'required',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => __('admin.required_msg'),
            'unique' => __('admin.unique_msg'),
            'lang.abbr.max' => __('admin.abbr_max'),
        ];
    }
}
