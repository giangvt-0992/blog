<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'Ticket.title'=> 'required|min:3',
            'Ticket.content' => 'required|min:10',
            'tags' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'Ticket.title.required'=> 'Bai viet phai co tieu de',
            'Ticket.title.min'=> 'Tieu de bai viet phai co do dai lon hon 3 ky tu',
            'Ticket.content.required' => 'Xin moi nhap noi dung bai viet',
            'Ticket.content.required' => 'Noi dung bai viet phai dai hon 10 ky tu',
            'tags.required' => 'Xin moi nhap noi dung bai viet'
        ];
    }
}
