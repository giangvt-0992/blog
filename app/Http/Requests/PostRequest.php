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
            'Post.title'=> 'required|min:3',
            'Post.content' => 'required|min:10',
            'tags' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'Post.title.required'=> 'Bai viet phai co tieu de',
            'Post.title.min'=> 'Tieu de bai viet phai co do dai lon hon 3 ky tu',
            'Post.content.required' => 'Xin moi nhap noi dung bai viet',
            'Post.content.required' => 'Noi dung bai viet phai dai hon 10 ky tu',
            'tags.required' => 'Xin moi nhap noi dung bai viet'
        ];
    }
}
