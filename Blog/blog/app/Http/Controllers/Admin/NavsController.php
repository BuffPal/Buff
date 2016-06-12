<?php

namespace App\Http\Controllers\Admin;

use App\Model\categorys;
use App\Model\navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class NavsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navs = navs::orderBy('order','asc')->get();
        return view('Admin/nav/list' , array('navs' => $navs));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/nav/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\create_nav $request)
    {
        $store = $request->all();
        $str = $request->all()['url'];
        //数据库查找 lists后面的字符串
        $egx = '/.*?\/lists\/(.*)/';

        if(preg_match_all($egx,$str,$arr)){
            //获取字符串
            $nav = $arr[1][0];
            //数据库检索
            $nid = categorys::where('name','=',$nav)->select('id')->get()[0]->id;
            //替换
            $egx = '/lists\/'.$nav.'/';
            $url = preg_replace($egx,'lists/'.$nid,$str);
            $store['url'] = $url;
        }

        if(navs::create($store)){
            return redirect('admin/nav')->with(array('alert'=>'添加成功','alertNum'=>'1'));
        }else{
            return back()->with(array('alert'=>'服务器正忙,请稍后重试','alertNum'=>'2'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取单条数据
        $data = navs::find($id);
        return view('Admin/nav/edit',array('data'=>$data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\create_nav $request, $id)
    {
        $store = $request->except('_token','_method');
        $str = $request['url'];
        //数据库查找 lists后面的字符串
        $egx = '/.*?\/lists\/(.*)/';

        if(preg_match_all($egx,$str,$arr)){
            //获取字符串
            $nav = $arr[1][0];
            //数据库检索
            $nid = categorys::where('name','=',$nav)->select('id')->get();
            $nid = $nid[0]->id;
            //替换
            $egx = '/lists\/'.$nav.'/';
            $url = preg_replace($egx,'lists/'.$nid,$str);
            $store['url'] = $url;
        }

        if(navs::where('id','=',$id)->update($store)){
            return redirect('admin/nav')->with(array('alert'=>'更新成功~!','alertNum'=>'1'));
        }else{
            return back()->with(array('alert'=>'服务正忙,请稍后重试~!','alertNum'=>'2'));
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
        if(navs::where('id','=',$id)->delete()){
            return json_encode(array('status'=>1,'msg'=>'删除成功~!'));
        }else{
            return json_encode(array('status'=>0,'msg'=>'服asdas务器正忙,请重试'));
        }
    }


    /**
     * 后台 navs AJAX 切换排序
     */
    public function changeOrder()
    {
        $data = Input::all();
        $nav = navs::find($data['id'])->update(array('order' => $data['order']));
        if ($nav) {
            echo json_encode(array('status' => 1 , 'msg' => '修改排序成功'));
        } else {
            echo json_encode(array('status' => 0 , 'msg' => '服务器正忙,请稍后重试'));
        }

    }
}
