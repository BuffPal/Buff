<?php
/**
 * 用户登录和注册控制器
 */
  namespace Index\Controller;
  use Index\Controller;
  Class LoginController extends CommonController{
    //登录
    Public function login(){
      $this->display();
    }

    //注册
    Public function register(){
      $this->display();
    }

    //登录验证
    Public function checkLogin(){
      if(!IS_POST) E('页面不存在~',404);
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

      session('uid',$user['id']);//写入用户ID
      UTF8();
      redirect(U('Index/index'),1,'登录成功正在跳转.......');

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

    //注册表单处理
    Public function checkRegister(){
      if(!IS_POST) E('页面不存在~',404);
      UTF8();
      //这里因为涉及到关联模型多表,所以不会用 自动验证
      if(check_verify(I('verify'))){
        $this->_checkAccount(I('account'));
        $this->_checkUsername(I('username'));
        $this->_checkPassword(I('password'));
        $this->_checkNotPassword(I('password'),I('notPassword'));
        $this->_checkEmail(I('email'));
        $data = array(
          'account'=>trimStrong(I('account')),
          'password'=>I('password','','md5'),
          'email'=>trimStrong(I('email')),
          'registerTime'=>time(),
          'userinfo'=>array(
            'username'=>trimStrong(I('username'))
            )
          );
        $user = D('UserRelation');
        if($id = $user->insert($data)){
          $this->success('注册成功',U('login'),1);
        }else{
          $this->error('服务器正忙,请稍后重试~');
        };
      }else{
        $this->error('验证码错误~');
      }
    }

    //验证账号 昵称 email 时候已经存在
    Public function checkAjax(){
      if(!IS_AJAX) E('页面不存在',404);
      $type = array_keys($_POST)[0];//这个函数能获得ajax发过来的 键名
      switch($type){
        case $type == 'account':
          if(M('user')->field('id')->where(array('account'=>$_POST[$type]))->find()){
            echo 'false';
          }
        break;
        case $type == 'username':
          if(M('userinfo')->field('id')->where(array('username'=>$_POST[$type]))->find()){
            echo 'false';
          }else{
            echo 'true';
          }
        break;
        case $type == 'email':
          if(M('user')->field('id')->where(array('email'=>$_POST[$type]))->find()){
            echo 'false';
          }else{
            echo 'true';
          }
        break;
        default:
          $this->error('未知错误!!!');
      }


    }

    //账号验证
    Private function _checkAccount($account){
      if(!empty($account)){
        if(mb_strlen(trimStrong($account)) >= 5 && mb_strlen(trimStrong($account)) <= 17){
          if(preg_match('/^([\w])(.*?)/',$account)){
            if(!preg_match("/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\ |\　/",trimStrong($account))){
              if(!(M('user')->field('id')->where(array('account'=>$account))->find())){
                return true;
              }else{
                $this->error('该账号已被注册.');
              }
            }else{
              $this->error('账号不能存在特殊字符');
            }
          }else{
            $this->error('账号第一个字符需要为字母');
          }
        }else{
          $this->error('账号因在5~17位之间');
        }
      }else{
        $this->error('账号不能为空');
      }
    }

    //昵称验证
    Private function _checkUsername($username){
        if(!empty($username)){
            if(mb_strlen(trimStrong($username)) >= 2 && mb_strlen(trimStrong($username)) <= 10){
                if(!preg_match("/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\ |\　/",trimStrong($username))){
                    if(!(M('userinfo')->field('id')->where(array('username'=>$username))->find())){
                      return true;
                    }else{
                        $this->error('用户名已存在!');
                    }
                }else{
                    $this->error('用户名不能存在特殊字符');
                }
            }else{
                $this->error('用户名需在2~10位之间');
            }
        }else{
            $this->error('昵称不能为空');
        }
    }

    //验证密码
    Private function _checkPassword($password){
        if(!empty($password)){
            if(mb_strlen($password) >=6 && mb_strlen($password) <= 20){
                return true;
            }else{
                $this->error('密码需要在6~20位之间');
            }
        }else{
            $this->error('密码不能为空');
        }
    }

    //确认密码
    Private function _checkNotPassword($password,$notPassword){
        if(!empty($password) || empty($notPassword)){
            if($password == $notPassword){
                return true;
            }else{
                echo $password.$notPassword;
                $this->error('两次输入密码不一致');
            }
        }else{
            $this->error('确认密码不能为空');
        }       
    }

    //电子邮箱验证 
    Private function _checkEmail($email){
        if(!empty($email)){
            if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)){
                if(!(M('user')->field('email')->where(array('email'=>$email))->find())){
                  return true;
                }else{  
                  $this->error('该邮箱已被注册');
                }
            }else{  
                $this->error('请输入正确的邮箱地址~');
            }
        }else{
            $this->error('电子邮箱不能为空');
        }

    }




    
  }