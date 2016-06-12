<?php
namespace Home\Controller;
class IndexController extends CommonController {
    //后台主页
    Public function index(){
      $this->display();
    }


    //后台主页侧栏
    Public function sidebar(){
      $this->display();
    }

    //后台主要显示 main
    Public function main(){

      //个人信息注入
      $this->username  = session('m_username');
      $this->loginTime = session('m_logintime');
      $this->loginIp   = session('m_loginip');
      $data = M('admin')->where(array('id'=>session('m_id')))->field(array('logintime','loginip'))->find();
      $this->nowLoginTime = date('Y-m-d H:i:s',$data['logintime']);

      //用户信息注入
      $this->userCount = M('user')->count('id');
      $this->userLocks = M('user')->where(array('locks'=>1))->count('id');


      //微博统计注入
      $this->wbCount      = M('weibo')->count('id');
      $this->wbOCount     = M('weibo')->where(array('isturn'=>array('neq','0')))->count('id');
      $this->commentCount = M('comment')->count('id');


      $this->display();
    }

    //后台主页头部
    Public function header(){
      //获取当前登陆的管理员
      $this->username  = session('m_username');
      $this->display();
    }

    //后台内容侧导航
    Public function sidebarn(){
      $this->display();
    }

    //后台内容侧导航
    Public function sidebars(){
      $this->display();
    }

    //后台内容侧导航
    Public function sidebaru(){
      $this->display();
    }

}