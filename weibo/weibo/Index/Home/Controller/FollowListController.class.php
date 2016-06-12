<?php 
/**
 * 粉丝列表,与关注列表控制器
 */
namespace Home\Controller;
use Think\Controller;

Class FollowListController extends CommonController{

  Public function index(){

    //config 路由写了判断(type=1:粉丝  type=0:关注)
    $type = I('type','','intval');
    $uid  = I('uid','','intval');
    if($uid != session('uid')) E('页面不存在~');
    
    //获取用户信息
    $this->userinfo = M('userinfo')->where(array('uid'=>$uid))->field(array('face','intro','username','uid','sex'))->find();
    
    //读取 粉丝OR关注 信息 (type=1:粉丝  type=0:关注)
    $where = $type ? array('follow'=>$uid) : array('fans'=>$uid);
    $field = $type ? array('fans') : array('follow');
    $uids  = M('follow')->where($where)->field($field)->select();
    if($uids){//如果用户没有粉丝 或者没有关注用户
        $name  = $type ? 'fans' : 'follow';//这里是为了下面函数第二个参数用的
        $uids  = TwoArrToOneArr($uids,$name);//二维数组转化为一维
      
        //分页输出
        $count = count($uids);// 查询满足要求的总记录数
        $Page  = new \Think\Page($count,18);// 实例化分页类 传入总记录数和每页显示的记录数(2)
        //page样式定义
        $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $Page->lastSuffix = false;//最后一页不显示为总页数

        $show   = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $whereU = array('uid'=>array('IN',$uids));
        $order  = 'fans DESC';
        $list   = M('userinfo')->where($whereU)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
        //用户互相关注 表查询 union  这里A()方法是调用 Search控制器里面的方法
        $Search = controller('Search');//controller 是提供调用别的控制器的方法  (下面的_getMutual 不能为Private)
        $data = $Search->_getMutual($list);
        $this->data = $data;
        $this->assign('page',$show);// 赋值分页输出
    }
    //注入总条数
    $this->count = $count;
    //注入当前显示的 title 
    $this->title = $type ? '粉丝' : '关注';

    $this->display();
  }





}
 ?>