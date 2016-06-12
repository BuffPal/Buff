<?php
  namespace Admin\Controller;
  use Think\Controller;
Class LoginController extends Controller{
  //登录页面
  Public function index(){
    $this->display();
  }


  //登录表单处理
  Public function checkLogin(){
    if(!IS_POST) E('页面不存在~',404);
    if(!check_verify(I('verify'))) $this->error('验证码错误');
    $where = array('account'=>I('account'),'password'=>I('password','','md5'));
    if($user = M('manages')->where($where)->field(array('account','logintime','loginip','id','logins'))->find()){
      //是否被锁定
      if(M('manages')->where(array('id'=>$user['id']))->getField('locks')) $this->error('该账号已被锁定,请联系管理员');
      //更新用户数据
      M('manages')->where(array('id'=>$user['id']))->save(array('logintime'=>time(),'loginip'=>get_client_ip()));
      //登录累计+1
      M('manages')->where(array('id'=>$user['id']))->setInc('logins');
      //写入session();
      session('mid',$user['id']);
      //写入管理员账号
      session('maccount',$user['account']);
      //上次登录时间
      session('mlogintime',$user['logintime']);
      //本次登录时间
      session('mnlogintime',time());
      //当前登录次数累计
      session('mlogins',$user['logins']);

      if(C('LOCATION_IP')){
        //上次登录IP
        session('mloginip',getIPLoc_QQ($user['loginip']));
        //本次登录IP
        session('mnloginip',getIPLoc_QQ(get_client_ip()));       
      }else{
        //上次登录IP
        session('mloginip',$user['loginip']);
        //本次登录IP
        session('mnloginip',get_client_ip());          
      }



      $this->success('登录成功正在跳转~',U('Index/index'),1);
    }else{
      $this->error('账号或密码不存在');
    }
  }

  //获取验证码
  Public function verify(){
    $config = array(
    'fontSize' => 32, // 验证码字体大小
    'length' => 4, // 验证码位数
    'useImgBg'=>true,
    'imageW'=>214,
    'imageH'=>80
    );
    $Verify = new \Think\Verify($config);
    $Verify->codeSet = '012345678';//这里是验证码指定的数字
    $Verify->entry();//输出验证码
  }





}
