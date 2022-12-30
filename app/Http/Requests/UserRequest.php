<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
        'name'=>'required',
        'email'=>[
            'required',
            Rule::unique('users')->ignore($this->id),
        ],
        'image'=>'mimes:png,jpg,jpeg',
        'phone'=>'required',
        'address'=>'required',
        'bio'=>'',
        'gender'=>'required',
        'role'=>'required',
        'job'=>'required',
        ];
    }
}
