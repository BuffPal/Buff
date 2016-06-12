<?php 
/**
 * 导航实体类
 */
class NavAction extends Action{
  public function __construct(&$_tpl){
    parent::__construct($_tpl,new NavModel());
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
      case 'showchild':
        $this->showchild();
        break;
      case 'addchild':
        $this->addchild();
        break;
      case 'sort':
        $this->sort();
        break;
      case 'addOrigami':
        $this->addOrigami();
        break;
      case 'updateOrigami':
        $this->updateOrigami();
        break;
      case 'deleteOrigami':
        $this->deleteOrigami();
        break;
      default:
        Tool::alertBack('非法操作!');
        break;
      }
    }
    }

    //业务流程控制器调用的函数,就在上面调用
    private function show(){
      $this->_tpl->assign('title','导航列表');
      $this->_tpl->assign('show',true);
      $cate = $this->_model->getAllToArray();
      $data = Tool::unlimitedForLayer($cate,0);
      $this->_tpl->assign('ALLNav',$data);          //这里用这个为了 分页 ,应为他有Limit
      //下面是注入Origami的变量
      $this->_tpl->assign('origamiMainId',$this->_model->getOneNavOrigami()->id);
      $this->_tpl->assign('origamiMainName',$this->_model->getOneNavOrigami()->origami_name);
      $this->_model->origami_pid = $this->_model->getOneNavOrigami()->id;//为了下面 找到里面的PID 唯一的父ID传过去
      $origami = $this->_model->getOrigamiChildALL();
      $this->_tpl->assign('ALLOrigamiNav',$origami);
    }

    private function add(){
      if(isset($_POST['addSubmit'])){
        if(Validate::checkNull($_POST['nav_name'])) Tool::alertBack('导航名不能为空');
        if(Validate::checkLength($_POST['nav_name'],1,'min')) Tool::alertBack('导航名不能小于1位或大于5位');
        if(Validate::checkLength($_POST['nav_name'],5,'max')) Tool::alertBack('导航名不能小于1位或大于5位');
        if(Validate::checkLength($_POST['nav_url'],200,'max')) Tool::alertBack('导航描述不能大于200位');
        $this->_model->nav_name = $_POST['nav_name'];
        if($this->_model->getOneNav()) Tool::alertBack('导航名称已存在');
        $this->_model->nav_url = $_POST['nav_url'];
        $this->_model->pid     = 0;
        if($this->_model->getNavTotal()>=6) Tool::alertBack('主导航个数已经满了!');
        $this->_model->addNav() ? Tool::alertLocation('添加成功!~','nav.php?action=show') : Tool::alertBack('添加失败!~');
      }
      $this->_tpl->assign('add',true);
      $this->_tpl->assign('title','添加导航');
    }

    private function update(){
     if(isset($_GET['id'])){
        $this->_model->id = $_GET['id'];
        $_nav = $this->_model->getOneNav();
        is_object($this->_model->getOneNav()) ? true : Tool::alertBack('找不到该导航的ID');
        //传值到修改方法里面 当作默认　value
        $this->_tpl->assign('id',$_nav->id);
        $this->_tpl->assign('nav_name',$_nav->nav_name);
        $this->_tpl->assign('nav_url',$_nav->nav_url);
        $this->_tpl->assign('title','修改导航');
        $this->_tpl->assign('prev_url',PREV_URL);
        $this->_tpl->assign('update',true);
       }else{
        Tool::alertBack('非法操作!');
       }
       //开始更新
       if(isset($_POST['submit'])){
          if(Validate::checkNull($_POST['nav_name'])) Tool::alertBack('导航名不能为空');
          if(Validate::checkLength($_POST['nav_name'],2,'min')) Tool::alertBack('导航名不能小于2位或大于20位');
          if(Validate::checkLength($_POST['nav_name'],5,'max')) Tool::alertBack('导航名不能小于2位或大于5位');
          if(Validate::checkLength($_POST['nav_url'],200,'max')) Tool::alertBack('导航描述不能大于200位');
          $this->_model->nav_name = $_POST['nav_name'];
          $this->_model->id       = $_POST['id'];
           if($this->_model->getOneNav2()->nav_name != $this->_model->nav_name){
            if($this->_model->getOneNav1()) Tool::alertBack('导航名称已存在');
          }
          $this->_model->nav_url = $_POST['nav_url'];
         $this->_model->updateNav() ? Tool::alertLocation('修改成功',$_POST['prev_url']) : Tool::alertBack('至少更改一样东西!');
       }
    }

    private function delete(){
     if(isset($_GET['id'])){
       $this->_model->id = $_GET['id'];
       $this->_model->deleteNav() ? Tool::alertLocation('删除成功!~',PREV_URL) : Tool::alertBack('删除失败!~');
      }
    }

    private function addchild(){
      if(isset($_POST['addSubmit'])){
        if(Validate::checkNull($_POST['nav_name'])) Tool::alertBack('子导航名不能为空');
        if(Validate::checkLength($_POST['nav_name'],1,'min')) Tool::alertBack('子导航名不能小于1位或大于5位');
        if(Validate::checkLength($_POST['nav_name'],6,'max')) Tool::alertBack('子导航名不能小于1位或大于6位');
        if(Validate::checkLength($_POST['nav_url'],200,'max')) Tool::alertBack('子导航URL不能大于200位');
        $this->_model->nav_name = $_POST['nav_name'];
        if($this->_model->getOneNav()) Tool::alertBack('导航名称和别的导航名重复!~');
        $this->_model->nav_url  = $_POST['nav_url'];
        $this->_model->pid      = $_POST['pid'];
        if($this->_model->getNavTotal()>=6) Tool::alertBack('这个导航的子导航数已经满了!');
        $this->_model->addNavchild() ? Tool::alertLocation('添加成功!~','nav.php?action=show') : Tool::alertBack('添加失败!~');
      }
      if(isset($_GET['id'])){
        $this->_model->id       = $_GET['id'];
        $nav = $this->_model->getOneNav();
        is_object($nav) ? true : Tool::alertBack('导航传值有误');
        $this->_tpl->assign('prev_id',$nav->id);
        $this->_tpl->assign('prev_name',$nav->nav_name);
        $this->_tpl->assign('id',$_GET['id']);
        $this->_tpl->assign('addchild',true);
        $this->_tpl->assign('title','新增子导航');
        $this->_tpl->assign('prev_url',PREV_URL);
      }
    }

    //前台主导航 显示条数
    public function showFront(){
      $cate = $this->_model->getAllToArray();
      $data = Tool::unlimitedForLayer($cate,0);
      $this->_tpl->assign('FrontNav',$data);
      //下面是折纸注入
      $this->_model->origami_pid = 1;
      $Odata = $this->_model->getOrigamiChildALLArray();
      foreach($Odata as $key=>$value){   //这里用foreach循环注入到首页的折纸动画里面 这里用$key来进行递增
        $this->_tpl->assign('origamiMainName'.($key+1),$value['origami_name']);
        $this->_tpl->assign('origamiMainUrl'.($key+1),$value['origami_url']);
      }
     
    }

    /*//sort 为了让后台能控制前台的排序  sort
    private function sort(){                    //这里不知道为什么不能用方法调用 只能在这里这样写  212课 17分钟
      if(isset($_POST['send'])){
        $sort = $_POST['s'];
       foreach($sort as $k=>$v){
          if(is_int($v)||$v>PAGE_SIZE) continue;
          $sql .= "UPDATE cms_nav SET sort='$v' WHERE id='$k';";
        }
        $db = DB::getDB();
        $db->multi_query($sql);
        DB::unDB($_result,$db);
        Tool::alertLocation(null,PREV_URL);
        echo "<script type='text/javascript'>history.go(0);</script>";
      }
    }*/

    //折纸添加
    public function addOrigami(){
       if(isset($_POST['addOrigami'])){
        if(Validate::checkNull($_POST['origami_name'])) Tool::alertBack('子折纸名不能为空');
        if(Validate::checkLength($_POST['origami_name'],1,'min')) Tool::alertBack('子折纸名不能小于1位或大于5位');
        if(Validate::checkLength($_POST['origami_name'],20,'max')) Tool::alertBack('子折纸名不能小于1位或大于20位');
        if(Validate::checkLength($_POST['origami_url'],200,'max')) Tool::alertBack('子折纸URL不能大于200位');
        $this->_model->origami_name = $_POST['origami_name'];
        if($this->_model->getOneNavOrigamiName()) Tool::alertBack('折纸名称不能重复!~');
        $this->_model->origami_url  = $_POST['origami_url'];
        $this->_model->origami_pid  = $_POST['pid'];
        if($this->_model->getNavOrigamiTotal()>=8) Tool::alertBack('折纸名称已经满了!');
        $this->_model->addNavOrigamichild() ? Tool::alertLocation('添加成功!~','nav.php?action=show') : Tool::alertBack('添加失败!~');
      }
      if(isset($_GET['id'])){
        $this->_model->id = $_GET['id'];
        $nav = $this->_model->getOneNav();
        is_object($nav) ? true : Tool::alertBack('导航传值有误');
        $this->_tpl->assign('prev_id',$nav->id);
        $this->_tpl->assign('prev_name',$nav->nav_name);
        $this->_tpl->assign('id',$_GET['id']);
        $this->_tpl->assign('addOrigami',true);
        $this->_tpl->assign('title','新增子折纸');
        $this->_tpl->assign('prev_url',PREV_URL);
      }
    }

    //折纸更新
    public function updateOrigami(){
      if(isset($_GET['id'])){
        $this->_model->id = $_GET['id'];
        $_origami = $this->_model->getOneNavOrigami1();
        is_object($this->_model->getOneNavOrigami1()) ? true : Tool::alertBack('找不到该折纸的ID');
        //传值到修改方法里面 当作默认　value
        $this->_tpl->assign('id',$_origami->id);
        $this->_tpl->assign('origami_name',$_origami->origami_name);
        $this->_tpl->assign('origami_url',$_origami->origami_url);
        $this->_tpl->assign('title','修改导航');
        $this->_tpl->assign('prev_url',PREV_URL);
        $this->_tpl->assign('updateOrigami',true);
       }else{
        Tool::alertBack('非法操作!');
       }
       //开始更新
       if(isset($_POST['submit'])){
          if(Validate::checkNull($_POST['origami_name'])) Tool::alertBack('折纸名不能为空');
          if(Validate::checkLength($_POST['origami_name'],2,'min')) Tool::alertBack('折纸名不能小于2位或大于20位');
          if(Validate::checkLength($_POST['origami_name'],5,'max')) Tool::alertBack('折纸名不能小于2位或大于5位');
          if(Validate::checkLength($_POST['origami_url'],200,'max')) Tool::alertBack('折纸描述不能大于200位');
          $this->_model->origami_name = $_POST['origami_name'];
          $this->_model->id       = $_POST['id'];
           if($this->_model->getOneNavOrigamiName1()->origami_name != $this->_model->origami_name){ //用来判断自己是否属于判断名字已存在的内容
            if($this->_model->getOneNavOrigamiName()) Tool::alertBack('折纸名称已存在');
          }
          $this->_model->origami_url = $_POST['origami_url'];
         $this->_model->updateOrigamiNav() ? Tool::alertLocation('修改成功',$_POST['prev_url']) : Tool::alertBack('至少更改一样东西!');
       }
    }

    //折纸删除
    public function deleteOrigami(){
     if(isset($_GET['id'])){
      if($_GET['id'] == 1) Tool::alertBack('该折纸无法删除!~'); 
       $this->_model->id = $_GET['id'];
       $this->_model->deleteOrigamiNav() ? Tool::alertLocation('删除成功!~',PREV_URL) : Tool::alertBack('删除失败!~');
      }
    }



}
 ?>