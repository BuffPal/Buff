<?php
/**
 * 前台首页控制器
 */
namespace Index\Controller;
use Index\Controller;
class IndexController extends CommonController {
   //首页页面
   Public function index(){
      //注入前台最新12个视频
      $newVideo = M('video')->field(array('videoname','playcount','videopicurl176','id','uploadtime'))->limit('12')->order('uploadtime DESC')->select();
      //判断是否为今天
      $new = date('Y-m-d');
      foreach($newVideo as $k=>$v){
        $old = date('Y-m-d',$v['uploadtime']);
        if($old == $new){
          $newVideo[$k]['isday'] = '1';
        }else{
          $newVideo[$k]['isday'] = '0';
        }
      }
      //注入信息
      $this->newVideo = $newVideo;


      //注入 音乐 最新推荐(uploadtime) 最热推荐(playcount)  历史排行(keepcount)
      $this->newMusic = $this->_getNewMusic();
      $this->hotMusic = $this->_getHotMusic();
      $this->oldMusic = $this->_getOldMusic();


      $this->navTitle = '首页';
      $this->display();
   }


/**
 * 获取最新的音乐列表 8条(缓存)
 */
Private function _getNewMusic(){
  if(S('newMusic')){
    return S('newMusic');
  }else{
    $newMusic = M('music')->field(array('id','musicname','author'))->limit('8')->order('uploadtime DESC')->select();
    S('newMusic',$newMusic,C('CACHE_MAX_TIME_HOTVIDEO'));//生成缓存
  }
  return $newMusic;
}


/**
 * 获取火的音乐列表 8条(缓存)
 */
Private function _getHotMusic(){
  if(S('hostMusic')){
    return S('hostMusic');
  }else{
    $hostMusic = M('music')->field(array('id','musicname','author'))->limit('8')->order('playcount DESC')->select();
    S('hostMusic',$hostMusic,C('CACHE_MAX_TIME_HOTVIDEO'));//生成缓存
  }
  return $hostMusic;
}


/**
 * 获取历史排行(old)的音乐列表 8条(缓存)
 */
Private function _getOldMusic(){
  if(S('oldMusic')){
    return S('oldMusic');
  }else{
    $oldMusic = M('music')->field(array('id','musicname','author'))->limit('8')->order('keepcount DESC')->select();
    S('oldMusic',$oldMusic,C('CACHE_MAX_TIME_HOTVIDEO'));//生成缓存
  }
  return $oldMusic;
}




}