<?php

namespace App\Http\Controllers\Admin;

use App\Model\links;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class LinksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = links::orderBy('order','asc')->get();
        return view('Admin/link/list' , array('links' => $links));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin/link/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\create_link $request)
    {
        if(links::create($request->all())){
            return redirect('admin/link')->with(array('alert'=>'添加成功','alertNum'=>'1'));
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
        $data = links::find($id);
        return view('Admin/link/edit',array('data'=>$data));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\create_link $request, $id)
    {
        $data = $request->except('_token','_method');
        if(links::where('id','=',$id)->update($data)){
            return redirect('admin/link')->with(array('alert'=>'更新成功~!','alertNum'=>'1'));
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
        if(links::where('id','=',$id)->delete()){
            return json_encode(array('status'=>1,'msg'=>'删除成功~!'));
        }else{
            return json_encode(array('status'=>0,'msg'=>'服务器正忙,请重试'));
        }
    }


    /**
     * 后台 links AJAX 切换排序
     */
    public function changeOrder()
    {
        $data = Input::all();
        $link = links::find($data['id'])->update(array('order' => $data['order']));
        if ($link) {
            echo json_encode(array('status' => 1 , 'msg' => '修改排序成功'));
        } else {
            echo json_encode(array('status' => 0 , 'msg' => '服务器正忙,请稍后重试'));
        }

    }


}
