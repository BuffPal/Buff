<?php

namespace App\Http\Controllers\Admin;

use App\Model\articles;
use App\Model\categorys;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //注入数据
        $cate = articles::getCate();    //分类
        $data = articles::jionCategorys();  //列表数据

        return view('Admin/article/list',array('article'=>$data,'cate'=>$cate));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //递归获取 分类
        $cate = articles::getCateHtml();

        return view('Admin/article/add',array('cate'=>$cate));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\create_article $request)
    {
        $data = $request->all();
        if(articles::create($data)){
            return redirect('admin/article');
        }else{
            return back()->with('msg','服务器正忙请稍后重试');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //获取分类信息
        $cate = articles::getCate();
        //获取 In() 数据
        $data = articles::getChildDataByIn($id);
        return view('Admin/article/show',array('article'=>$data,'cate'=>$cate,'cate_id'=>$id));
    }

    public function search()
    {
        //获取分类信息
        $cate = articles::getCate();

        $keyword = Input::get('keywords');
        //获取关键字 查找
        $data = articles::getDataByKeyword($keyword);

        return view('Admin/article/search',array('article'=>$data,'cate'=>$cate,'keyword'=>$keyword));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //递归获取 分类
        $cate = articles::getCateHtml();
        //获取 当前 $id 文章数据
        $data = articles::find($id);

        return view('Admin/article/edit',array('cate'=>$cate,'data'=>$data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\create_article $request, $id)
    {
        $data = $request->all();
        //获取 旧的 缩略图地址
        $oldThumb = articles::where('id','=',$id)->select('thumb')->first()->thumb;
        //获取 新的 缩略图地址
        $newThumb = $data['thumb'];
        $num = mb_strpos($newThumb,env('CROPPIC_PATH'));
        $newThumb = mb_substr($newThumb,$num);
        //进行 新旧对比
        if($oldThumb != $newThumb){
            $path = public_path().'/'.$oldThumb;
            @unlink($path);
        }

        //执行更新
        if(articles::where('id','=',$id)->update($request->except('_token','_method'))){
            return redirect('admin/article')->with(array('alert'=>'更新成功!','alertNum'=>1));
        }else{
            return back()->with(array('alert'=>'服务器正忙,请稍后重试','alertNum'=>2));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thumb_path = articles::where('id','=',$id)->select('thumb')->first()->thumb;
        //执行删除
        if(articles::where('id','=',$id)->delete()){
            //删除它保存的缩略图
            $path = public_path().'/'.$thumb_path;
            @unlink($path);
            
            return json_encode(array('status'=>1,'msg'=>'删除成功'));
        }else{
            return json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
        }
    }
}
