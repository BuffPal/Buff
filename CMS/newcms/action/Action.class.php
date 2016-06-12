<?php  
/**
 * Action 基类用于Action调用
 */
class Action{
  protected $_tpl;
  protected $_model;

  protected function __construct(&$_tpl,&$_model){
    $this->_tpl = $_tpl;
    $this->_model = $_model;
  }

  protected function page($_total){
      $page = new Page($_total,PAGE_SIZE);  //第一个是有多少数据 , 第二个是每页显示多少数据
      $this->_model->limit = $page->limit;                          //用 $page里面返回的Limit 来查找分页信息
      $this->_tpl->assign('page',$page->showpage());
      $this->_tpl->assign('num',($page->page-1)*PAGE_SIZE);           ///用来   205 课 19分钟  用来排序`
  }


}
 ?>
