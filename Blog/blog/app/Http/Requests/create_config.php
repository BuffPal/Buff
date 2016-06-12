<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class create_config extends Request
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
            'title'=>'required',
            'name'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'请输入,配置项标题名',
            'name.required'=>'请输入,配置项名称'
        ];
    }
}
