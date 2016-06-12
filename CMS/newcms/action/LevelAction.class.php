<?php
/**
 * 等级实体类
 */
class LevelAction extends Action{
  public function __construct(&$_tpl){
    parent::__construct($_tpl,new LevelModel());
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
      default:
        Tool::alertBack('非法操作!');
        break;
      }
    }
    }

    //业务流程控制器调用的函数,就在上面调用
    private function show(){
      parent::page($this->_model->getLevelTotal()); /////总共多少条传入进去
      $this->_tpl->assign('title','等级列表');
      $this->_tpl->assign('show',true);
      $this->_tpl->assign('ALLLevel',$this->_model->getLimitLevel());          //这里用这个为了 分页 ,应为他有Limit
    }

    private function add(){
      if(isset($_POST['addSubmit'])){
        if(Validate::checkNull($_POST['level_name'])) Tool::alertBack('等级名不能为空');
        if(Validate::checkLength($_POST['level_name'],2,'min')) Tool::alertBack('等级名不能小于2位或大于20位');
        if(Validate::checkLength($_POST['level_name'],20,'max')) Tool::alertBack('等级名不能小于2位或大于20位');
        if(Validate::checkLength($_POST['level_info'],200,'max')) Tool::alertBack('描述不能大于200位');
        $this->_model->level_name = $_POST['level_name'];
        if($this->_model->getOneLevel()) Tool::alertBack('等级名称已存在');
        $this->_model->level_info = $_POST['level_info'];
        $this->_model->addLevel() ? Tool::alertLocation('添加成功','level.php?action=show') : Tool::alertBack('添加失败,请重新添加');
      }
       $this->_tpl->assign('title','添加等级');
       $this->_tpl->assign('add',true);
    }

    private function update(){
       if(isset($_GET['id'])){
        $this->_model->id = $_GET['id'];
        $_level = $this->_model->getOneLevel();
        is_object($this->_model->getOneLevel()) ? true : Tool::alertBack('找不到该用户的ID');
        //传值到修改方法里面 当作默认　value
        $this->_tpl->assign('id',$_level->id);
        $this->_tpl->assign('level_name',$_level->level_name);
        $this->_tpl->assign('level_info',$_level->level_info);
        $this->_tpl->assign('title','修改等级');
        $this->_tpl->assign('prev_url',PREV_URL);
        $this->_tpl->assign('update',true);
       }else{
        Tool::alertBack('非法操作!');
       }

       //开始更新
       if(isset($_POST['submit'])){
          if(Validate::checkNull($_POST['level_name'])) Tool::alertBack('等级名不能为空');
          if(Validate::checkLength($_POST['level_name'],2,'min')) Tool::alertBack('等级名不能小于2位或大于20位');
          if(Validate::checkLength($_POST['level_name'],20,'max')) Tool::alertBack('等级名不能小于2位或大于20位');
          if(Validate::checkLength($_POST['level_info'],200,'max')) Tool::alertBack('描述不能大于200位');
          $this->_model->id         = $_POST['id'];
          $this->_model->level_name = $_POST['level_name'];
          if($this->_model->getOneLevel()->level_name != $this->_model->level_name){ //用来判断自己是否属于判断名字已存在的内容
            if($this->_model->getOneLevel1()) Tool::alertBack('折纸名称已存在');
          }
          $this->_model->level_info = $_POST['level_info'];
         $this->_model->updateLevel() ? Tool::alertLocation('修改成功',$_POST['prev_url']) : Tool::alertBack('至少更改一样东西!');
       }
    }

    private function delete(){
     if(isset($_GET['id'])){
       $this->_model->id = $_GET['id'];
       $_manage = new ManageModel();
       $_manage->level = $this->_model->id;
       if($_manage->getOneManage()) Tool::alertBack('该等级有别的管理员在使用,无法删除');
       $this->_model->deleteLevel() ? Tool::alertLocation('删除成功',PREV_URL) : Tool::alertBack('删除失败');
      }
    }



}
 ?>