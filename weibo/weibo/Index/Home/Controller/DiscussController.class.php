<?php 
/**
 * 详细评论控制器
 */
namespace Home\Controller;
use       Think\Controller;
Class DiscussController extends CommonController{

  Public function index(){
    $wid = I('wid','','intval');
    $this->wid = $wid;
    $this->sessionUid = session('uid');
    $this->operationWeibo = U('Self/operationWeibo');//转发跳转地址
    $this->data = D('SelfView')->getOneComment(array('id'=>$wid));//后台取来这条微博的数据
    $this->hotsoso = 'aaaa';

    //分页显示评论
    $db = D('SelfCommentView');
    $where = array('wid'=>$wid);
    $order = 'time DESC';
    $count = $db->where($where)->count();// 查询满足要求的总记录数
      $Page  = new \Think\Page($count,C('INDEX_SERCH_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数在配置文件中定义
      $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $Page->lastSuffix = false;//最后一页不显示为总页数

      $show = $Page->show();// 分页显示输出
      // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $list = $db->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
      $list = stringDate($list,'time');
      $this->self = M('userinfo')->where(array('uid'=>session('uid')))->field(array('username,uid,face'))->find();
  /*   UTF8();
      p($self);
      die;*/
      $this->list = $list;

      $this->assign('page',$show);// 赋值分页输出




    $this->display();
  }


  //微博转发处理
  Public function operationWeibo(){
    if(!IS_POST) E('页面不存在~',404);
    $this->redirect('Self/operationWeibo', $_POST, 0, '页面跳转中...');
  }







}
 ?>