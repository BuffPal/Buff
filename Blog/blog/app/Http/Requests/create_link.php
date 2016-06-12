<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class create_link extends Request
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
            'name'=>'required|max:255',
            'info'=>'max:255',
            'url'=>'required|max:255'
        ];
    }

    /**
     * 提示信息
     */
    public function messages()
    {
        return [
            'name.required'    => '请填写链接名' ,
            'url.required'   => '请输入链接地址' ,
            'name.max'        => '请保证链接名在255位之内' ,
            'info.max'     => '请保证链接简介在255为之内' ,
            'url.max' => '请保证链接URL在255位之内'
        ];
    }
}
