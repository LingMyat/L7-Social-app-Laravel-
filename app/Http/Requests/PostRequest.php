<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title'=>'required',
            'content'=>'required',
            'image_galleries'=>'required',
            'user_id'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'image_galleries.required'=>"Images Field is Required"
        ];
    }
}
