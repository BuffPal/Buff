<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class create_nav extends Request
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
            'name'  => 'required|max:20' ,
            'ename' => 'required|max:50' ,
            'url'   => 'required|max:255'
        ];
    }

    /**
     * 提示信息
     */
    public function messages()
    {
        return [
            'name.required'  => '请填写导航名' ,
            'ename.required' => '请填写导航英文提示' ,
            'url.required'   => '请输入url跳转地址' ,
            'name.max'       => '请保证导航名在20位之内' ,
            'ename.max'      => '请英文提示在50为之内' ,
            'url.max'        => '请保证跳转URL在255位之内'
        ];
    }
}
