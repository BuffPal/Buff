<?php 
/**
 * 视频列表视图模型
 */
namespace Admin\Model;
use Think\Model\ViewModel;
Class VideoViewModel extends ViewModel{
  //定义关联关系
  protected $viewFields = array(
      'video' => array(
        'id'=>'vid','videopicurl176','videopicurl','videoname','size','playcount','comment','topcount','uploadtime','keepcount','videourl',
        '_type'=>'LEFT'
      ),
      'manages' => array(
        'account',
        '_on'=>'video.mid = manages.id',
        '_type'=>'LEFT'
        ),
      'videoclassify' => array(
        'name','id'=>'classid',
        '_on'=>'video.cid=videoclassify.id'
        )
    );

  //对外公开方法
  Public function getAll($where,$limit = ''){
    $result = $this->where($where)->limit($limit)->order('video.uploadtime DESC')->select();
    return $result;
  }



}