<?php 
/**
 * 管理员增删改查 实体类
 */
class ManageAction extends Action{
  public function __construct(&$_tpl){
    parent::__construct($_tpl,new ManageModel());
  }


  //action方法,用来manage的各种业务流程控制
  public function _action(){
    if(isset($_GET['action'])){
      switch ($_GET['action']) {
        case 'show':
           $this->show();
          break;
        case 'add':
           $this->add();
          break;
        case 'update':
          $this->update();
          break;
        case 'delete':
          $this->delete();
          break;
          Tool::alertBack('非法操作!');
          break;
        }
    }
    }

    //业务流程控制器调用的函数,就在上面调用
    private function show(){
      parent::page($this->_model->getManageTotal());
      $this->_tpl->assign('title','管理员列表');
      $this->_tpl->assign('show',true);
      $this->_tpl->assign('ALLManage',$this->_model->getManage());
    }

    private function add(){
      if(isset($_POST['addSubmit'])){
        if(Validate::checkNull($_POST['admin_user'])) Tool::alertBack('用户名不能为空!');
        if(Validate::checkLength($_POST['admin_user'],2,'min')) Tool::alertBack('用户名不得小于两位!');
        if(Validate::checkLength($_POST['admin_user'],20,'max')) Tool::alertBack('用户名不得大于20位!');
        if(Validate::checkNull($_POST['admin_pass'])) Tool::alertBack('密码不能为空!');
        if(Validate::checkLength($_POST['admin_pass'],6,'min')) Tool::alertBack('密码不得小于6位!');
        if(Validate::checkEquals($_POST['admin_pass'],$_POST['admin_notpass'])) Tool::alertBack('两次密码不相同');
        $this->_model->admin_user = $_POST['admin_user'];
        if($this->_model->getOneManage()) Tool::alertBack('管理员名称已经存在');
        $this->_model->admin_pass = sha1($_POST['admin_pass']);
        $this->_model->level      = $_POST['level'];
        $this->_model->addManage() ? Tool::alertLocation('添加成功','manage.php?action=show') : Tool::alertBack('添加失败,请重新添加');
      }
       $this->_tpl->assign('title','添加管理员');
       $this->_tpl->assign('add',true);
       $this->_tpl->assign('prev_url',PREV_URL);
       $level = new LevelModel();
       $this->_tpl->assign('levelSelect',$level->getLevel());
    }

    private function update(){
       if(isset($_GET['id'])){
        $this->_model->id = $_GET['id'];
        $_level = $this->_model->getOneManage();
        is_object($this->_model->getOneManage()) ? true : Tool::alertBack('找不到该用户的ID');
        //传值到修改方法里面 当作默认　value
        $this->_tpl->assign('id',$_level->id);
        $this->_tpl->assign('level',$_level->level);
        $this->_tpl->assign('admin_user',$_level->admin_user);
        $this->_tpl->assign('admin_pass',$_level->title);
        $this->_tpl->assign('title','修改管理员');
        $this->_tpl->assign('update',true);
        $this->_tpl->assign('prev_url',PREV_URL);
        $level = new LevelModel();
        $this->_tpl->assign('levelSelect',$level->getLevel());
       }else{
        Tool::alertBack('非法操作!');
       }

       //开始更新
       if(isset($_POST['submit'])){
        $this->_model->id=$_POST['id'];
        if(trim($_POST['admin_pass']) == ''){
            $this->_model->admin_pass=$_POST['passa'];
          }else{
            if(Validate::checkLength($_POST['admin_pass'],6,'min')) Tool::alertBack('密码不能小于6位');
            $this->_model->admin_pass=sha1($_POST['admin_pass']);
          }
         $this->_model->level = $_POST['level'];
         $this->_model->updateManage() ? Tool::alertLocation('修改成功',$_POST['prev_url']) : Tool::alertBack('请至少更改一个东西!');
       }
    }

    //删除方法
    private function delete(){
     if(isset($_GET['id'])){
       $this->_model->id = $_GET['id'];
       $this->_model->deleteManage() ? Tool::alertLocation('删除成功',PREV_URL) : Tool::alertBack('删除失败');
      }
    }

 

  
}
 ?>