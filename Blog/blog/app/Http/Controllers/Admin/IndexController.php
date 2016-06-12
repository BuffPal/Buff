<?php

namespace App\Http\Controllers\Admin;

use App\Model\manages;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class IndexController extends Controller
{
    //后台首页
    public function index()
    {
        return view('Admin/index');
    }

    //后台首页基本信息
    public function info()
    {
        return view('Admin/info');
    }

    //修改管理员密码 显示页面
    public function pass()
    {
        return view('Admin/pass');
    }

    public function checkpass(Requests\adminRevisePassword $data)
    {
        $manage_id = Session::get('manage')->id;
        //获取当前用户的数据库密码
        $oldpass = manages::where('id' , '=' , $manage_id)->pluck('password')->toArray()[0];
        $inputPass = $data->password_o;
        if ($oldpass == md5($inputPass)) {
            $newpassword = $data->password;
            $msg = manages::find($manage_id)->update(array('password' => md5($newpassword)));
            if ($msg) {
                Session::forget('manage');
                return redirect('admin/login');
            } else {
                return back()->with('msg' , '服务器正忙,请重试');
            }
        } else {
            return back()->with('msg' , '原密码不正确,请重试');
        }
    }


}
