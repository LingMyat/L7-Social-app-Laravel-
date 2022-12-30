<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'sender_id'=>'required',
            'reciever_id'=>'required',
            'content'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'reciever_id.required' => 'You Need To Select One Friend',
            'content.required' => 'A message Body is Required',
        ];
    }
}
