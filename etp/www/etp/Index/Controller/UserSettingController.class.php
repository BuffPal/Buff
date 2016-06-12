<?php
/**
 * 用户个人设置页(个人中心)
 */
  namespace Index\Controller;
  use Index\Controller;
  Class UserSettingController extends CommonController{
    //主要显示
    Public function index(){
      //判断用户是否登录
      if(!session('uid')) redirect(U('Login/login'));

      //注入默认信息
      $where = array('uid'=>session('uid'));
      $field = array('username','truename','location','sex','day','intro','blog','msn','qq');
      $data  = M('userinfo')->where($where)->field($field)->find();

      //把day 转换为数组   location就不转了,前台js写的有
      if(!empty($data['day'])){
        $data['day'] = explode(',',$data['day']);
      }

      //注入电子邮箱地址
      $this->email = M('user')->where(array('id'=>session('uid')))->getField('email');
      //注入默认信息
      $this->userinfo = $data;
      $this->display();
    }



    /**
     * 基本信息验证
     */
    Public function saveBasic(){
      if(!IS_POST) E('页面不存在~',404);
      UTF8();
      if(!empty($_POST)){
        //实例化 用户个人信息模型
        $userinfo = new \Index\Model\UserinfoModel();
        //用于自动验证收集表单信息,同时触发表单自动验证
        $data = $userinfo->create();
        //转换数组成字符串(location,day)
        $data['location'] = implode(',',$data['location']);
        $data['day'] = implode(',',$data['day']);

        //插入数据库
        if(M('userinfo')->where(array('uid'=>session('uid')))->save($data)){
          $this->success('保存成功',C('PREV_UREL'),1);
        }else{
          $msg = $userinfo->getError() ? $userinfo->getError() : '请至少修改一个值';
          $this->error($msg);//输出验证错误信息
        }
      }
    }

    /**
     * AJAX 用户名是否存在(注意!存在的用户名不为自己)
     */
    Public function checkUsername(){
      if(!IS_AJAX) E('页面不存在~',404);
      $where = array('username'=>I('username'),'uid'=>array('NEQ',session('uid')));
      if(M('userinfo')->where($where)->getField('id')){
        echo "false";
      }else{
        echo "true";
      }
    }


    /**
     * 修改密码表单处理
     */
    Public function revisePW(){
      if(!IS_POST) E('页面不存在~',404);
      $oldPassword    = I('oldPassword','','md5');
      $newPassword    = I('newPassword');
      $newNotPassword = I('newNotPasswrod');

      //先判断密码新密码长度
      if(mb_strlen($newPassword) >= 6 && mb_strlen($newPassword) <= 20){
        //判断密码两次密码是否相等
        if($newPassword == $newNotPassword){
          //判断旧密码是否正确
          if(M('user')->where(array('id'=>session('uid')))->getField('password')==$oldPassword){
            //更新数据库
            if(M('user')->where(array('id'=>session('uid')))->save(array('password'=>md5($newPassword)))){
              //清除session(),和cookie
              session_unset();
              session_destroy();
              setcookie('auto','',time()-1,"/");
              $this->success('密码修改成功,正在返回登录页面',U('Login/login'),3);
            }else{
              $this->error('服务器正忙,请稍后重试');
            }
          }else{
            $this->error('旧密码输入错误!');
          }
        }else{
          $this->error('两次密码输入不一致');
        }
      }else{
        $this->error('密码长度因在6~20之间~');
      }

    }


  }