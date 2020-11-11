<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfile extends FormRequest
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
            'user_name' => 'required|unique:users|min:3',
            'password'  => 'min:6',
            'name'      => 'string|min:3',
            'bio'       => 'max:512',
            'phone'     => 'regex:/^[0][9][1][0-9]{8,8}$/',
            'email'     => 'email',
        ];
    }

    public function messages()
    {
        return [
            'user_name.required'    => 'لطفا نام کاربری را وارد نماید',
            'user_name.unique'      => 'این نام قبلا ثبت شده است',
            'user_name.min'         =>  'نام کاربری نمیتواند از سه حرف کوچکتر باشد',
            'password.required'     =>  'لطفا پسورد را وارد نمایید',
            'password.min'          => 'رمز عبور باید ۶ حرف یا بیشتر باشد',
            'name.string'           =>  'نام خود را لطفا بصورت صحیح وارد کنید',
            'name.min'              =>  'حداقل حروف باید بیشتر از سه باشد',
            'bio.max'               =>  'حداکثر طول مجاز ۵۱۲ کارکتر میباشد',
            'phone.regex'           =>  'شماره موبایل صحیح نمیباشد',
            'email.email'           =>  'ایمیل صحیح نمیباشد!'
        ];
    }
}
