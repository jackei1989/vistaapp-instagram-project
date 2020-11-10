<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthUserLogin extends FormRequest
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
            'user_name' => 'required|min:3',
            'password'  => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'user_name.required'    => 'لطفا نام کاربری را وارد نماید',
            'user_name.min'         =>  'نام کاربری نمیتواند از سه حرف کوچکتر باشد',
            'password.required'     =>  'لطفا پسورد را وارد نمایید',
            'password.min'          => 'رمز عبور باید ۶ حرف یا بیشتر باشد',
        ];
    }
}
