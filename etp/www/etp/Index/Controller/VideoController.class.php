<?php
/**
 * 首页视频播放
 */
namespace Index\Controller;
use Index\Controller;
Class VideoController extends CommonController{
  //视频主页  -------------该功能暂不做
  Public function index(){
    $this->display();
  }


  //视频列表页(无限级分类) -----------该功能暂不做
  Public function lists(){
    $this->display();
  }

  //视频详情页单视频显示 
  Public function details(){
    $vid = I('id','','intval');
    //判断别报错了
    if(!empty($vid)){
      $data = M('video')->where(array('id'=>I('id','','intval')))->field('mid,videopicurl176',true)->find();
      $this->data = $data;
    }else{
      //redirect(C('PREV_UREL'));  这里没有写视频列表页
    }

    //数据库给它的播放次数加一
    M('video')->where(array('id'=>$vid))->setInc('playcount');

    //注入侧栏选集
    $count = M('videoclassify')->field(array('id','fid'))->select();
    $cate  = getChildsID($count,$data['cid']);
    $cate[]= $data['cid'];
    $cate  = implode(',',$cate);
    $where = array('fid'=>array('in',$cate));
    $sdata = M('video')->where($where)->field(array('videoname','playcount','id','uploadtime'))->order('uploadtime DESC')->select();
    $this->sdata = $sdata;
   

    //注入大家都在看(这里用缓存)
    $hotVideo = $this->_getHotVideo();
    //判断是否为今天
    $new = date('Y-m-d');
      if($hotVideo){
      foreach($hotVideo as $k=>$v){
        $old = date('Y-m-d',$v['uploadtime']);
        if($old == $new){
          $hotVideo[$k]['isday'] = '1';
        }else{
          $hotVideo[$k]['isday'] = '0';
        }
      }
      $this->hotVideo = $hotVideo;
    }

    //获取相关视频(就是用视频名去检索————表示这里准备用分词,项目结束后补上来.先注入fid下面的视频)
    $xgfield = array('id','videoname','playcount','comment','videopicurl176');
    $xgdata  = M('video')->where(array('fid'=>$data['cid']))->field($xgfield)->limit('8')->order('playcount DESC')->select();
    $this->xgdata = $xgdata;

    //注入面包屑
    $nav = $this->_getnav($data['cid']);
    $this->navlength = count($nav);
    $this->nav = $nav;


    $this->navTitle = '视频';
    $this->display();
  }

/**
 * 视频详情页点赞处理同时生成cookie
 */
Public function topcountAjax(){
  if(!IS_AJAX) E('页面不存在~',404);
  //获取ID值
  $id = I('vid','','intval');
  //判断cookie存不存在
  if($_COOKIE['video'.$id]){
    echo json_encode(array('status'=>0,'msg'=>'您已经点过赞了~'));
  }else{
    //创建cookie
    cookie('video'.$id,$id,3600*24);
    //数据库更新
    M('video')->where(array('id'=>$id))->setInc('topcount');
    echo json_encode(array('status'=>1,'msg'=>'收到您宝贵的一赞~'));
  }
}


/**
 * 获得视频详细页播放分量最多的5条信息(缓存)
 */
//用于注入后台最先的最火的微博评论排行榜
Private function _getHotVideo(){
  if(S('hotVideo')){
    return S('hotVideo');
  }else{
    $hotVideo = M('video')->field(array('videopicurl176','uploadtime','videoname','id','playcount'))->order('comment DESC')->limit('5')->order('playcount DESC')->select();
    S('hotVideo',$hotVideo,C('CACHE_MAX_TIME_HOTVIDEO'));//生成缓存
  }
  return $hotVideo;
}

/**
 * 传来一个视频ID 获取面包屑导航
 */
Private function _getnav($vid){
  $html = '';
  //获取全部classify 视频分类
  $count = M('videoclassify')->field(array('name','id','fid'))->select();
  $cate = getParents($count,$vid);
  //注入一个$key的值,用于前段解决循环面包的时候出现多一个&gt;
  foreach($cate as $key=>$v){
    $cate[$key]['key'] = $key+1;
  }
  return $cate;
}



  
}