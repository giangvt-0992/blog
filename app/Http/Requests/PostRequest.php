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
     * @return array
     */
    public function rules()
    {
        return [
            'title'=> 'required|min:3',
            'content' => 'required|min:10'
        ];
    }

    public function messages()
    {
        return [
            'title.required'=> 'Bai viet phai co tieu de',
            'title.min'=> 'Tieu de bai viet phai co do dai lon hon 3 ky tu',
            'content' => 'required|min:10'
        ];
    }
}
