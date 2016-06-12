<?php

namespace App\Http\Controllers\Admin;

use App\Model\articles;
use App\Model\categorys;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CategorysController extends Controller
{
    /**
     * Display a listing of the resource.
     *  全部分类列表
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = categorys::orderBy('order' , 'asc')->get();
        //使用递归
        $categorys = unlimitedForLevel($categorys , '┣━━');
        return view('Admin/category/list' , array('categorys' => $categorys));
    }


    /**
     * Display a listing of the resource.
     *  添加分类
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = categorys::getParent();
        return view('Admin/category/add' , array('parent' => $data));
    }

    /**
     * Store a newly created resource in storage.
     *添加分类处理
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\create_categorys $request)
    {
        if (categorys::create($request->all())) {
            return redirect('admin/category')->with('success','添加成功!');
        } else {
            return back()->with('msg','服务器正忙请稍后重试');
        }
    }

    /**
     * Display the specified resource.
     *  显示单个分类
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = categorys::getParent();
        $field = categorys::find($id);
        return view('Admin/category/edit',array('parent'=>$data,'field'=>$field));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\create_categorys $request , $id)
    {
        //判断当前的分类是否有子级分类,如果有不能让他改动 pid
        if(categorys::verfiyChild($id)){
            //获取原来的ID
            $old = categorys::find($id);
            if($request->pid != $old->pid){
                return back()->with('msg','当前分类下,还存在子级分类,不允许修改父级,请修改子级分类后再操作');
            }
        }
        
        $re = categorys::where('id','=',$id)->update($request->except('_token','_method'));
        if($re){
            return redirect('admin/category')->with('success','修改成功!');
        }else{
            return back()->with('msg','服务器正忙请稍后重试');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //判断是否存在子分类
        if(categorys::verfiyChild($id)){
            return json_encode(array('status'=>0,'msg'=>'当前分类下存在子级分类,暂无法删除!'));
        }

        //判断当前分类之下是否存在文章
        if($num = articles::where('cid','=',$id)->count()){
            return json_encode(array('status'=>0,'msg'=>'当前分类下还存在'.$num.'篇文章,暂无法删除'));
        }

        //执行删除
        if(categorys::where('id','=',$id)->delete()){
            return json_encode(array('status'=>1,'msg'=>'删除成功'));
        }else{
            return json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
        }

    }

    /**
     * 后台 category AJAX 切换排序
     */
    public function changeOrder()
    {
        $data = Input::all();
        $category = categorys::find($data['id'])->update(array('order' => $data['order']));
        if ($category) {
            echo json_encode(array('status' => 1 , 'msg' => '修改排序成功'));
        } else {
            echo json_encode(array('status' => 0 , 'msg' => '服务器正忙,请稍后重试'));
        }

    }


}
