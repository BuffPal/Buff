<?php 
/**
 * 收藏微博视图模型
 */
namespace Home\Model;
use Think\Model\ViewModel;
class KeepViewModel extends ViewModel {

    //表关联条件
    protected $viewFields = array(
        'keep' => array(
            'id'=>'kid','time'=>'ktime',
            '_type'=>'INNER'
          ),
        'weibo' => array(
            'id'=>'id','content','isturn','time','turn','praise','comment',
            '_on'=>'keep.wid = weibo.id',
            '_type'=>'LEFT'
          ),
        'picture' => array(
            'max',
            '_on'=>'picture.wid = weibo.id',
            '_type'=>'LEFT'
          ),
        'userinfo' => array(
            'username','face','uid',
            '_on'=>'weibo.uid = userinfo.uid'
          )
      );


    //对外获取方法
    Public function getAll($where,$limit = ''){
      $result = $this->where($where)->limit($limit)->order('keep.time DESC')->select();
      $db = D('SelfView');
      foreach ($result as $k => $v){
        if($v['isturn'] > 0){
          $result[$k]['isturn'] = $db->find($v['isturn']);//这里find()传入了一条where 就是 id = $v['isturn'] 默认找ID吧
        }
      }
      return $result;
    }
}