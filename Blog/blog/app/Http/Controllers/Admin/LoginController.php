<?php

namespace App\Http\Controllers\Admin;

use App\Model\manages;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;

class LoginController extends Controller
{

    /**
     * 显示页面
     */
    public function index()
    {
        //拒绝登录用户,访问
        if(session('manage'))
        {
            return redirect('admin/index');
        }
        return view('Admin/login');
    }

    /**
     * 登录验证
     */
    public function store(Request $request)
    {
        //判断验证码是否正确
        if (Session::get('verify') === $request->code) {
            $data = manages::where('account' , '=' , $request->account)
                ->where('password' , '=' , md5($request->password))
                ->first();
            if ($data) {
                //管理员信息写入 SESSION
                Session::put('manage',$data);
                return redirect('admin/index');
            } else {
                return back()->with('msg' , '账号或密码错误');
            }
        } else {
            return back()->with('msg' , '验证码错误~');
        }
    }

    /**
     * 退出 清理session
     */
    public function logout()
    {
        Session::forget('manage');
        return redirect('admin/login');
    }

}
