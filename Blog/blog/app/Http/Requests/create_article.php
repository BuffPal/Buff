<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class create_article extends Request
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
    {//'title','content','time','editor','tag','description','info','thumb','cid'
        return [
            'title'       => 'required|between:2,255' ,
            'content'     => 'required' ,
            'editor'      => 'required|max:50' ,
            'tag'         => 'required|between:2,100' ,
            'description' => 'required|between:2,255' ,
            'info'        => 'required|between:2,255' ,
            'thumb'       => 'required' ,
            'cid'         => 'required'
        ];
    }

    /**
     * 提示信息
     */
    public function messages()
    {
        return [
            'title.required'       => '请输入文章的标题' ,
            'title.between'        => '请保证文章标题在 2 ~ 255 位之内' ,
            'content.required'     => '请输入文章内容' ,
            'editor.required'      => '请输入编辑名称' ,
            'editor.max'           => '编辑名称应在255位之内' ,
            'tag.required'         => '请输入TAG标签' ,
            'tag.between'          => 'TAG标签应在2~100位之内' ,
            'description.required' => '请输入关键字秒速' ,
            'description.between'  => '关键字描述应在2~100位之内' ,
            'info.required'        => '请输入文章简介' ,
            'info.between'         => '文章简介应在2~255位之内' ,
            'thumb.required'       => '请上传文章缩略图' ,
            'cid.required'         => '必须选着上传的分类'
        ];
    }
}
