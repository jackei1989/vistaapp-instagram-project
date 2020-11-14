<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStore extends FormRequest
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
            'content'   => 'required|max:255',
            'post_id'   => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'content.required'      => 'متن مورد نظر خود را بنویسید ',
            'content.max'           => 'طول کامنت شما بیشتر از حد مجاز است. طول مجاز برابر با ۲۵۵ کاراکتر میباشد',
            'post_id.required'      => 'پست وجود ندارد!',
            'post_id.numeric'       => 'فرمت صحیح نمیباشد'             
        ];
    }
}
