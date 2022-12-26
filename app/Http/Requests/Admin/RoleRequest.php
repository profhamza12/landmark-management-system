<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => 'required|min:2|unique:roles,name,' . $this->id,
            'role.display_name.*' => 'required|min:2|unique_translation:roles,display_name,' . $this->id,
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => trans('content.requiredMsg'),
            'unique' => trans('content.uniqueMsg'),
            'name.min' => trans('content.groupnamemin'),
            'role.display_name.*.min' => trans('content.groupnamemin'),
        ];
    }
}
