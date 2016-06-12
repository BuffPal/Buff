<?php 
/**
 * 微博发布表关联模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class SelfViewModel extends ViewModel {
  //定义覆盖视图表查询
  protected $viewFields=array(
          'weibo'=>array('content',
                         'isturn',
                         'time',
                         'turn',
                         'praise',
                         'comment',
                         'uid',
                         'id',
                         '_type'=>'LEFT'
                        ),
          'userinfo'=>array('username',
                            'face',
                            '_type'=>'LEFT',
                            '_on'=>'weibo.uid=userinfo.uid'
                           ),
          'picture'=>array('mini',
                           'medium',
                           'max',
                           '_on'=>'weibo.id=picture.wid'
                          )
);

  /**
   * 对外查询条件
   * @param  [array] $where [查询条件]
   * @return [type]        [查询出来的数组]
   */
  Public function getAll($where,$limit){
    $result = $this->where($where)->order(array('time'=>'DESC'))->limit($limit)->select();
    if($result){
      foreach($result as $k=>$v){
        if($v['isturn']){
          $tmp = $this->where(array('id'=>$v['isturn']))->find();
          $result[$k]['isturn'] = $tmp ? $tmp : -1;//这里的判断语句都是基于 weibo这个表 因为他是第一个 LEFT
        }
      }
    }
  return $result;
  }

  /**
   * 获取一条数据,用户 显示更多的评论页面
   * @param  [type] $where [description]
   * @return [type]        [description]
   */
  Public function getOneComment($where){
    $result = $this->where($where)->find();
    if($result){
      if($result['isturn']){
        $result['isturn'] = $this->where(array('id'=>$result['isturn']))->find();
      }
    }
      return $result;
  }


  
}