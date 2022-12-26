<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\User;
use http\Env\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'user.name.*' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users,email,' . $this->id,
            'phone' => 'required|min:8|regex:/^[0-9]+$/|unique:users,phone,' . $this->id,
            'password' => 'required|min:6',
            'user.address.*' => 'required|min:4',
            'roles' => 'required',
            'photo' => 'required|mimes:jpg,jpeg,png'
        ];
        if (in_array(request()->method(), ['PUT', 'PATCH']))
        {
            $rules['password'] = 'sometimes|nullable|min:6';
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
            'user.name.*.min' => trans('content.usernamemin'),
            'phone.min' => trans('content.phonemin'),
            'phone.regex' => trans('content.phoneregex'),
            'password.min' => trans('content.userpassmin'),
            'user.address.*.min' => trans('content.addressmin'),
            'mimes' => trans('content.mimesMsg'),
        ];
    }
}
