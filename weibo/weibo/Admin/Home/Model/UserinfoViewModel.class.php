<?php 
/**
 * 用户信息关联表  user userinfo
 */
namespace Home\Model;
use Think\Model\ViewModel;
class UserinfoViewModel extends ViewModel {
   //定义覆盖视图表查询
  protected $viewFields=array(
      'user'=>array(
          'locks','registime',
          '_type'=>'INNER'
        ),
      'userinfo'=>array(
          'username','face','intro','uid','fans','follow','weibo',
          '_on'=>'user.id=userinfo.uid'
        )
    );

/**
   * 对外查询条件
   * @param  [array] $where [查询条件]
   * @return [type]        [查询出来的数组]
   */
  Public function getAll($where,$limit){
    $result = $this->where($where)->order(array('user.id'=>'DESC'))->limit($limit)->select();
    if($result){
      foreach($result as $k=>$v){
        if($v['locks']){
          $result[$k]['locks'] = '锁定';
        }else{
          $result[$k]['locks'] = '未锁定';
        }
      }
    }
  return $result;
  }



}