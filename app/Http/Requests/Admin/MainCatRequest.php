<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\User;
use Illuminate\Foundation\Http\FormRequest;

class MainCatRequest extends FormRequest
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
            'maincat.name.*' => 'required|min:2|unique_translation:main_categories,name,' . $this->id,
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
            'maincat.name.*.min' => trans('content.maincatnamemin'),
            'mimes' => trans('content.mimesMsg'),
        ];
    }
}
