<?php
namespace Home\Controller;
use       Think\Controller;
Class LoginController extends Controller{
  //登录控制器
  Public function index(){
    
    $this->display();
  }

  //form 提交检查
  Public function checkLogin(){
    if(!IS_POST) E('页面不存在~',404);
    $manageName = I('manageName');
    $pass       = I('managePass','','md5');
    $verify     = I('code');
    $where = array('manageName'=>$manageName,'managePass'=>$managePass);
    if(!check_verify($verify)) $this->error('验证码错误');
    if($manage = M('admin')->where($where)->find()){//登录成功
      session('m_id',$manage['id']);
      session('m_username',$manage['username']);
      session('m_logintime',$manage['logintime']);
      session('m_loginip',$manage['loginip']);
      $this->success('登录成功',U('Index/index'));

      $data = array(//更新数据
        'logintime' => time(),
        'loginip' => get_client_ip()
        );
      M('admin')->where(array('id'=>$manage['id']))->data($data)->save();
    }else{
      $this->error('账号或密码错误~!');
    }
  }



   //验证码
    Public function verify(){
      $config = array(
      'fontSize' => 40, // 验证码字体大小
      'length' => 4, // 验证码位数
      'useImgBg'=>true
      );
      $Verify = new \Think\Verify($config);
      $Verify->codeSet = '012345678';//这里是验证码指定的数字
      $Verify->entry();//输出验证码
    }



}