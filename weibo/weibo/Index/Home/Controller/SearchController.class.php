<?php 
/**
 * 搜索控制器
 */
namespace Home\Controller;
Class SearchController extends CommonController{

  //导航栏搜索页面
  public function search(){
    if(!IS_GET) E('页面不存在',404);
      //检索出 除了自己外 昵称含有关键字的用户
      $db     = M('userinfo');
      $where  = array(
                      'uid'=>array('NEQ',$_SESSION['uid']),//查找不是自己的
                      array(
                            'username'=>array('LIKE','%'.I('keyword').'%'),//查询名字里面的关键字
                        ),
        );
      $fieldOne         = array('username','intro','face','sex','location','follow','fans','weibo','uid','id');
      $fieldRelatedUser = array('username','intro','face','uid');//用于相关用户查询
      $order            = array('fans'=>'DESC');
      $resultOne        = $db->where($where)->field($fieldOne)->order($order)->find();
      $this->resultOne  = $this->_getMutualOne($resultOne);

      
      //这里这样用是为了 过滤上面找到一个最高粉丝的用户 不知道为啥刚刚那样用有BUG
        $whereR  = array(
                      'uid'=>array('NEQ',$_SESSION['uid']),//查找不是自己的
                      array(
                            'username'=>array('LIKE','%'.I('keyword').'%'),//查询名字里面的关键字
                            'intro' => array('LIKE','%'.I('keyword').'%'),//查询介绍里面的关键字
                            '_logic'=>'OR'//用OR
                        ),
                      'id'=>array('NEQ',$resultOne['id']),
        );
      $this->result  = $db->where($whereR)->field($fieldRelatedUser)->order($order)->limit('0,6')->select();
      $this->keyword = I('keyword');
      $this->hotwb   = $this->_getHotWB();//注入最火的10条微博
      $this->display();
  }

  public function searchren(){
    if(!IS_GET) E('页面不存在',404);

    //检索出 除了自己外 昵称含有关键字的用户
      $db     = M('userinfo');
      $where  = array(
                      'uid'=>array('NEQ',$_SESSION['uid']),//查找不是自己的
                      array(
                            'username'=>array('LIKE','%'.I('keyword').'%'),//查询名字里面的关键字
                            'intro' => array('LIKE','%'.I('keyword').'%'),//查询介绍里面的关键字
                            '_logic'=>'OR'//用OR
                        ),
        );
      $fieldAll         = array('username','intro','face','sex','location','follow','fans','weibo','uid');
      $order  = array('fans'=>'DESC');
      //我也是醉了 thinkphp 自动过滤数组中的 html 代码,只能这样写了                     //其实直接在模板里面调用就行,当时不知道

      $count = $db->where($where)->count();// 查询满足要求的总记录数
      $Page  = new \Think\Page($count,C('INDEX_SERCH_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
      $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
        $Page->lastSuffix = false;//最后一页不显示为总页数

      $show = $Page->show();// 分页显示输出
      // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
      $list = $db->where($where)->order($order)->limit($Page->firstRow.','.$Page->listRows)->select();
      //用户互相关注 表查询 union
      $follow = $this->_getMutual($list);
      $this->result = $follow ? $follow : false;//false用来判断 是否搜索到相关数据
      $this->assign('page',$show);// 赋值分页输出

    //$this->result = $result;
    $this->keyword = I('keyword');
    $this->hotwb   = $this->_getHotWB();//注入最火的10条微博
    $this->display();
  }

  /**
   * 用于修改结果集 ,达到判断当前用户是否与被搜索的用户相互关注
   * @param  [array] $result [要修改的数组]
   * @return [array]         [返回的数组]
   */
  Public function _getMutual($result){//这个就是在 关注表里面查询 互相关注的信息
    if(!$result) return false;
    $db = M('follow');
    foreach ($result as $k=>$v){//UNION 关键字相当于合并数组
      //是否关注
      $sql =  '(SELECT
                      `fans`
                FROM
                      `wb_follow`
                WHERE
                      `follow`='.$v['uid'].'
                  AND
                      `fans`='.session('uid').'
             ) UNION (SELECT
                            `fans`
                      FROM
                            `wb_follow`
                      WHERE
                            `follow`='.session('uid').'
                      AND
                            `fans`='.$v['uid'].'
             )';
             $mutual = $db->query($sql);
    if(count($mutual) == 2){//判断用户是否互相关注
      $result[$k]['mutual'] = 2;
    }else{
      if($mutual[0]['fans'] == session('uid')){//判断是否只有一方关注(用户)
        $result[$k]['mutual'] = 1;
      }else{//都没有关注
      $result[$k]['mutual'] = 0;
      }
    }
  }
    return $result;
}


/**
   * 用于修改结果集 ,达到判断当前用户是否与被搜索的用户相互关注
   * @param  [string] $result [字段]
   * @return [array]         [返回的数组]
   */
  Public function _getMutualOne($result){
    if(!$result) return false;
    $db = M('follow');
      //是否关注
      $sql =  '(SELECT
                      `fans`
                FROM
                      `wb_follow`
                WHERE
                      `follow`='.$result['uid'].'
                  AND
                      `fans`='.session('uid').'
             ) UNION (SELECT
                            `fans`
                      FROM
                            `wb_follow`
                      WHERE
                            `follow`='.session('uid').'
                      AND
                            `fans`='.$result['uid'].'
             )';
             $mutual = $db->query($sql);
    if(count($mutual) == 2){//判断用户是否互相关注
      $result['mutual'] = 2;
    }else{
      if($mutual[0]['fans'] == session('uid')){//判断是否只有一方关注(用户)
        $result['mutual'] = 1;
      }else{//都没有关注
      $result['mutual'] = 0;
      }
    }
    return $result;
}

//用于注入后台最先的最火的微博评论排行榜
Private function _getHotWB(){
  if(S('hotwb')){
    return S('hotwb');
  }else{
    $HotWb = M('weibo')->field(array('content','comment','id'))->order('comment DESC')->limit('10')->select();
    S('hotwb',$HotWb,C('CACHE_MAX_TIME'));//生成缓存
  }
  return $HotWb;
}

}
 ?>