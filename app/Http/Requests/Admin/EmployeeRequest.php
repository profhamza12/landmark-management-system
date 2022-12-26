<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'employee.name.*' => 'required|min:2|max:100',
            'phone' => 'required|min:8|regex:/^[0-9]+$/|unique:employees,phone,' . $this->id,
            'employee.address.*' => 'required|min:4',
            'employee.qualification.*' => 'required',
            'salary' => 'required',
            'national_id' => 'required|numeric',
            'created_at' => 'required',
            'date_of_birth' => 'required',
            'branch' => 'required',
            'groups' => 'required',
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
            'employee.name.*.min' => trans('content.employeenamemin'),
            'phone.min' => trans('content.phonemin'),
            'phone.regex' => trans('content.phoneregex'),
            'employee.address.*.min' => trans('content.addressmin'),
            'mimes' => trans('content.mimesMsg'),
        ];
    }

}
