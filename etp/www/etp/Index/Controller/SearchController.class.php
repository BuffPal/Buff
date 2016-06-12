<?php
/**
 * 表单搜索控制器
 */
namespace Index\Controller;
use Index\Controller;
Class SearchController extends CommonController{

   //接收数据处理
   Public function search(){
      if(!IS_POST) E('页面不存在~');
      $type = I('type');
      $keyword = trimStrong(I('keyword'));
      switch($type){
         case 'music':
            $this->_musicSearch($keyword);
         break;
         case 'video':
            $this->_videoSearch($keyword);
         break;
         case 'article':
            $this->_articleSearch($keyword);
         break;
      }
   }

   //音乐搜索页面
   Private function _musicSearch($keyword){
      echo "音乐界面".$keyword;
   }

   //电影搜索页面
   Private function _videoSearch($keyword){
      echo "电影界面".$keyword;
   }

   //文章搜索页面
   Private function _articSearch($keyword){
      echo "文章界面".$keyword;
   }



}