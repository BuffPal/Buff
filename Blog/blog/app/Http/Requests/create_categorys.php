<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class create_categorys extends Request
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
            'pid'         => 'required' ,
            'name'        => 'bail|required|between:2,20' ,
            'info'        => 'max:100' ,
            'keyword'     => 'max:100' ,
            'description' => 'max:255' ,
            'order'       => 'alpha_num'
        ];
    }

    /**
     * 提示信息
     */
    public function messages()
    {
        return [
            'pid.required'    => '请选着您的根分类' ,
            'name.required'   => '必须输入分类名' ,
            'name.between'    => '分类名必须在 2 ~ 20 位之间' ,
            'info.max'        => '请保证分类描述在100位之内' ,
            'keyword.max'     => '请保证关键字在100为之内' ,
            'description.max' => '请保证关键字描述在255位之内' ,
            'order.alpha_num'     => '分类排序必须为数字'
        ];
    }


}
