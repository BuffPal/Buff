<?php
namespace Home\Controller;
use       Think\Controller;
Class CommonController extends Controller{
  //自动运行方法
  Public function _initialize(){
    if(!session('m_id')){
      redirect(U('Login/index'));
    }
  }

  //退出
  Public function logOut(){
    session_unset();//卸载session
    session_destroy();//销毁session
    redirect(U('Login/index'));
  }
}