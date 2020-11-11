<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStore extends FormRequest
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
            'image'     => 'required|mimes:jpeg,bmp,png,jpg',
            'content'   => 'max:512'
        ];
    }

    public function messages()
    {
        return [
            'image.required'   =>  'تصویر مورد نظر خود را انتخاب کنید',
            'image.mimes'   =>  'شما فقط به آپلود عکس میباشید',
            'content.max'   =>  'حداکثر کارکتر مجاز ۲۵۵ کارکتر میباشد'
        ];
    }
}
