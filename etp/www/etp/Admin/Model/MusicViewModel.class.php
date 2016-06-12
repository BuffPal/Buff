<?php  
namespace Admin\Model;
use Think\Model\ViewModel;
Class MusicViewModel extends ViewModel{
  //定义关联关系
  protected $viewFields = array(
      'music' => array(
        'id'=>'mid','musicbgurl','musicname','size','playcount','author','uploadtime','keepcount',
        '_type'=>'LEFT'
      ),
      'manages' => array(
        'account',
        '_on'=>'music.mid = manages.id',
        '_type'=>'LEFT'
        ),
      'musicclassify' => array(
        'name','id'=>'classid',
        '_on'=>'music.cid=musicclassify.id'
        )
    );

  //对外公开方法
  Public function getAll($where,$limit = ''){
    $result = $this->where($where)->limit($limit)->order('music.uploadtime DESC')->select();
    return $result;
  }



}