<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class adminRevisePassword extends Request
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
            'password_o'=>'required',
            'password'=>'required|between:6,20|confirmed',
        ];
    }

    /**
     * 提示信息
     */
    public function messages()
    {
        return [
            'password_o.required'=>'请输入您的原密码',
            'password.required'=>'请输入您的新密码',
            'password.between'=>'请新密码保证在 6 ~ 20 位之间',
            'password.confirmed'=>'两次输入密码不相同',
        ];
    }
    
}
