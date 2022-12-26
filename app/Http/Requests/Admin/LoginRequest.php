<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        $rules = [];
        if (isset($this->email))
        {
            $rules['email'] = 'required|email';
        }
        if (isset($this->password))
        {
            $rules['password'] = isset($this->password_confirmation) ? 'required|min:5|confirmed' : 'required|min:5';
        }
        if ($this->has('token'))
        {
            $rules['token'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => __('admin.required_msg'),
            'email' => __('admin.email_msg'),
            'password.min' => __('admin.password_length'),
            'password.confirmed' => __('admin.confirmed')
        ];
    }
}
