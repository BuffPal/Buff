<?php
/**
 * 用户管理 控制器
 */
namespace Home\Controller;
Class UserController extends CommonController{

  //用户管理_____微博用户
  Public function wbuser(){
    //注入用户信息
    $count = M('userinfo')->count('id');
    if(!empty($count)){//如果用户没有关注
      $Page  = new \Think\Page($count,C('INDEX_SERCH_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
      $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
      $Page->setConfig('prev', '上一页');
      $Page->setConfig('next', '下一页');
      $Page->setConfig('last', '末页');
      $Page->setConfig('first', '首页');
      $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
      $Page->lastSuffix = false;//最后一页不显示为总页数
      
      $show   = $Page->show();// 分页显示输出
      $where  = array();
      $limit  = $Page->firstRow.','.$Page->listRows;
      $result = D('UserinfoView')->getAll($where,$limit);
      $result = stringDate($result,'registime');
      $this->resultAll = $result;
      $this->assign('page',$show);// 赋值分页输出
    }
    $this->display();
  }


  /**
   * ajax locks 处理
   */
  Public function locks(){
    if(!IS_AJAX) E('页面不存在~','404');
    $id = I('uid','','intval');
    $status = I('status');
    if($status == '锁定'){//判断用户当前状态
      $locks = '0';
    }else{
      $locks = '1';
    }
    $data = array(
        'locks' => $locks
      );
    if(M('user')->where(array('id'=>$id))->data($data)->save()){
      echo json_encode(array('status'=>1,'msg'=>'切换成功'));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器出错,请联系负责管理员'));
    }


  }







}