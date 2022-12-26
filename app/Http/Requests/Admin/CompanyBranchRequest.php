<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyBranchRequest extends FormRequest
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
            'branch.name.*' => 'required|min:2|unique_translation:company_branches,name,' . $this->id,
            'branch.address.*' => 'required|min:4',
            'branch.country.*' => 'required',
            'phone' => 'required|min:8|regex:/^[0-9]+$/',
            'email' => 'required|email',
            'website' => ['required', 'regex:/^((http|https)\:\/\/)?(www\.)?[a-zA-z0-9]+\.[a-zA-z]{2,4}$/'],
            'photo' => 'required|mimes:jpg,jpeg,png',
            'branch.activity.*' => 'required',
            'finance_year' => 'required|numeric',
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
            'email' => trans('content.emailMsg'),
            'mimes' => trans('content.mimesMsg'),
            'branch.name.*.min' => trans('content.branchnamemin'),
            'branch.address.*.min' => trans('content.branchaddressmin'),
            'phone.min' => trans('content.branchphonemin'),
            'phone.regex' => trans('content.branchphoneregex'),
            'website.regex' => trans('content.branchwebsiteregex'),
        ];
    }
}
