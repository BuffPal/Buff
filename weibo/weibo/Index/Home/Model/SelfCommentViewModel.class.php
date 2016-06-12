<?php 
/**
 * 微博用户评论视图模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class SelfCommentViewModel extends ViewModel {
  //定义覆盖视图表查询
  protected $viewFields=array(
          'comment'=>array('content',
                           'time',
                           'uid',
                           'wid',
                           'id'
                          ),
          'userinfo'=>array(
                          'username',
                          'face',
                          '_on'=>'comment.uid=userinfo.uid'
                            )

);

  /**
   * 对外查询条件
   * @param  [array] $where [查询条件]
   * @return [type]        [查询出来的数组]
   */
  Public function getCommentAll($where){
    $result = $this->where($where)->order(array('time'=>'DESC'))->limit('0,10')->select();
    if($result){
      $result = stringDate($result,'time');
    }
    foreach($result as $k=>$v){
      $result[$k]['content'] = replace_weibo($v['content']);
    }
  return $result;
  }



}