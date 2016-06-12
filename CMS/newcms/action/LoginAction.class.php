<?php 
  class LoginAction extends Action{

    public function __construct(&$_tpl){
      parent::__construct($_tpl,new ManageModel());
    }
    
    //构造
    public function _action(){
        switch ($_GET['action']){
          case 'login':
            $this->login();
            break;
          case 'logout':
            $this->logout();
            break;
        }
    }

    //后台登录验证方法 用于 action = login
    private function login(){
      if(isset($_POST['send'])){
        if(Validate::checkLength($_POST['code'],4,'equals')) Tool::alertBack('验证码错误!~');
        if(Validate::checkEquals(sha1(strtolower($_POST['code'])),$_SESSION['code'])) Tool::alertBack('验证码错误!~');
        if(Validate::checkNull($_POST['admin_user'])) Tool::alertBack('用户名不能为空!~');
        if(Validate::checkNull($_POST['admin_pass'])) Tool::alertBack('密码不能为空!~');
        if(Validate::checkLength($_POST['admin_user'],2,'min')) Tool::alertBack('账号或密码错误!~');
        if(Validate::checkLength($_POST['admin_user'],20,'max')) Tool::alertBack('账号或密码错误!~');
        if(Validate::checkLength($_POST['admin_pass'],6,'min')) Tool::alertBack('账号或密码错误!~');
        $this->_model->admin_user = $_POST['admin_user'];
        $this->_model->admin_pass = sha1($_POST['admin_pass']);
        $this->_model->last_ip    = $_SERVER["REMOTE_ADDR"];
        $this->_model->setLoginCount();
        $login = $this->_model->getLoginManage();
        if($login){
          $_SESSION['admin']['admin_user'] = $login->admin_user;
          $_SESSION['admin']['level_name'] = $login->level_name;
          Tool::alertLocation(null,'admin.php');
        }else{
          Tool::alertBack('账号或密码错误!~');
        }
      }
    }

      //后台退出功能
    private function logout(){
      Tool::unSession();
      Tool::alertLocation(null,'admin_login.php');
    }

  }
 ?>