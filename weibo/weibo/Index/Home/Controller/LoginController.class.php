<?php 
/**
 * 注册与登录控制器
 */
namespace Home\Controller;
use Think\Controller;
Class LoginController extends Controller{
  //登录页面
  public function index(){
    $this->display();
  }

  public function cacheLogin(){
    if(!IS_POST) E('页面不存在',404);
    $model = M('User');
    $userArr = array('account'=>I('account'),'password'=>I('password','','md5'));
    $user = $model->where($userArr)->find();//查找当前登录用户是否存在
    if(!$user) $this->error('账号或密码错误');//判断用户是否存在
    if($user['locks']) $this->error('您的账号已被锁定,请联系管理员');//判断用户是否锁定

    if(isset($_POST['auto'])){//13课  在登录的时候勾选 下次自动时  生成加密 的 cookie(带密钥)
      $account = $user['account'];
      $ip      = get_client_ip();//获取客户端IP地址
      $value   = $account.'|'.$ip;
      $value   = encryption($value);//这个是一个加密函数  在Common里面(自定义的)
      setcookie('auto',$value,C('AUTO_LOGIN_TIME'),'/');
    }

      session('uid',$user['id']);
      UTF8();
      redirect(U('Self/index'),1,'登录成功正在跳转.......');
  }






  //注册页面
  public function register(){
    $this->display();
  }

  //表单提交处理
  public function runRegister(){
    if(!IS_POST) E('页面不存在',404);
    $verify = I('verify');
    if(!check_verify($verify)) $this->error('验证码错误');
    if(I('password') !== I('notPassword')) $this->error('两次输入密码一致');
    $data = array(
      'account'   =>I('account'),
      'password'  =>I('password','','md5'),
      'registime' =>$_SERVER['REQUEST_TIME'],
      'userinfo'  => array(
          'username'  => I('username')
        )
      );

    $id = D('UserRelation')->insert($data);
    if($id){//插入数据后 写session 
      session('uid',$id);
      UTF8();//发送个编码过去,防止出现乱码
      redirect(U('Self/index'),2,'注册成功,马上跳转');
    }else{
      $this->error('注册失败,请重新注册');
    }


  }

  //获取验证码
  public function verify(){
    $config = array(
    'fontSize' => 40, // 验证码字体大小
    'length' => 4, // 验证码位数
    'useImgBg'=>true
    );
    $Verify = new \Think\Verify($config);
    $Verify->codeSet = '012345678';//这里是验证码指定的数字
    $Verify->entry();//输出验证码
  }

  //AJAX 验证 account和username
  public function cacheAjax(){
    if (!IS_AJAX) E('页面不存在',404);
    $account = I('account');
    if(M('user')->where(array('account'=>$account))->getField('id')){
      echo "该用户已被注册";
    }else{
      echo "可以注册";
    }
  }


}