<?php
/**
 * 音乐控制器
 */
namespace Index\Controller;
use Index\Controller;
Class MusicController extends CommonController{
  //音乐主页  -------------该功能暂不做
  Public function index(){
    $this->display();
  }

  //音乐列表页(二级分类)
  Public function lists(){
    //注入的栏目数据(这里就不能用unlimitedForLevel 这里需要注入一个二维数组)
    $this->classifyLists = $this->_getClassify();

    //右侧的列表页
    $where = array();//定义一个空的数组用下面来做判断
    //判断是否是点击二级栏目进来的
    if(!empty($_GET['cid'])){
      //注入当前获得的cid(classify)给前台让前台的JS控制左边的手风琴
      $this->nowCid = I('cid','','intval');
      $where = array('cid'=>I('cid','','intval'));
    }


    //分页处理
    $count = M('music')->where($where)->count('id');
    $db    = M('music');
    $Page  = new \Think\Page($count,C('MUSIC_LISTS_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
    $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
    $Page->setConfig('prev', '上一页');
    $Page->setConfig('next', '下一页');
    $Page->setConfig('last', '末页');
    $Page->setConfig('first', '首页');
    $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $Page->lastSuffix = false;//最后一页不显示为总页数

    $show = $Page->show();// 分页显示输出
    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $limit = $Page->firstRow.','.$Page->listRows;

    //注入结果
    $resultAll = M('music')->where($where)->limit($limit)->field(array('musicname','author','playcount','id'))->order('playcount DESC')->select();
    $this->assign('page',$show);// 赋值分页输出
    $this->resultAll = $resultAll;

    $this->navTitle='音乐';
    $this->display();
  }

  //音乐详情页单视频显示(这里能看见歌词) -----------该功能暂不做
  Public function details(){
    $this->display();
  }


/**
 * 获取音乐列表页的左边二级分类(缓存)
 */
Private function _getClassify(){
  if(S('musicclassify')){
    return S('musicclassify');
  }else{
    $cate = M('musicclassify')->field(array('id','name','fid','faceurl'))->select();
    $cate = unlimitedForLayer($cate);
    S('musicclassify',$cate,C('CACHE_MAX_TIME_HOTVIDEO'));//生成缓存
  }
  return $cate;
}



}