<?php 
/**
 * 网站首页控制器
 */
namespace Home\Controller;
use Think\Controller;
Class IndexController extends Controller{

  //首页视图
  Public function index(){
    $id = isset($_GET['id']) ? $id = $_GET['id'] : session('uid');//判断是不是_getUrl()发过来的

    //url 输入的ID不存在该用户时处理
    if(!M('user')->where(array('id'=>$id))->getField('id')){
      //判断用户是否登陆
      if(session('uid')){
        $id = session('uid');
      }else{ //给我回登录页面去
        redirect(U('Login/index'));
      }
    }


    $this->operationWeibo = U('Self/operationWeibo');//因为是header.html 这里给他注入一下from的提交地址

    //注入用户基本信息
    $field    = array('username','face','intro','follow','fans','weibo','uid');
    $where    = array('uid'=>$id);
    $list     = M('userinfo')->field($field)->where($where)->find();//发送数组data过去
    if(session('uid')){//加这个判断是因为 Search 继承的是Common 所以 未登录用户不能进入
      $Search   = controller('Search');//controller 是提供调用别的控制器的方法  (下面的_getMutual 不能为Private)
      $userinfo = $Search->_getMutualOne($list);//判断当前查看用户是否 时候关注该主页用户
      $this->userinfo = $userinfo;
    }else{
      $this->userinfo = $list;
    }
    

    //因为这里继承的Controller 游客也可以登陆 这里判断下时候有uid的值 用于给js处理
    $this->userUid = M('userinfo')->where(array('uid'=>session('uid')))->find();

    //注入粉丝列表
    if(S('follow_'.$id)){//判断缓存时候存在
      $fansData = S('follow_'.$id);
    }else{
      $uids     = M('follow')->where(array('follow'=>$id))->field(array('fans'))->select();
      if($uids){//防报错处理
        $uids     = TwoArrToOneArr($uids,'fans');
        $where    = array('uid'=>array('IN',$uids));
        $field    = array('username','face','uid');
        $fansData = M('userinfo')->where($where)->field($field)->order('fans DESC')->limit(7)->select();

        S('follow_'.$id,$fansData,C('CACHE_MAX_TIME'));//生成缓存
      }
    }
    $this->fansData = $fansData;



     //注入用户所关注的人
     if(S('fans_'.$id)){//判断缓存时候存在
      $followData = S('fans_'.$id);
     }else{
       $fuids       = M('follow')->where(array('fans'=>$id))->field(array('follow'))->select();
       if(!empty($fuids)){//他没有关注人,就不循环了
         $fuids       = TwoArrToOneArr($fuids,'follow');
         $where      = array('uid'=>array('IN',$fuids));
         $field      = array('username','face','uid','follow','fans','weibo');
         $followData = M('userinfo')->where($where)->field($field)->order('fans DESC')->limit(8)->select();
           //压入 最新发布的微博
         foreach($followData as $k=>$v){
          $weibo = M('weibo')->where(array('uid'=>$v['uid']))->field(array('id','content'))->order('time DESC')->limit('1')->find();
          $followData[$k]['content'] = omitString($weibo['content'],16);
          $followData[$k]['wid'] = $weibo['id'];
         }
       }
       S('fans_'.$id,$followData,C('CACHE_MAX_TIME'));//生成缓存
     }
     $this->followData = $followData;




    //注入用户微博
    $db    = M('weibo');
    $where = array('uid'=>$id);
    $count = $db->where($where)->count('id');
    $Page  = new \Think\Page($count,C('INDEX_WEIBO_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
    $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
    $Page->setConfig('prev', '上一页');
    $Page->setConfig('next', '下一页');
    $Page->setConfig('last', '末页');
    $Page->setConfig('first', '首页');
    $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $Page->lastSuffix = false;//最后一页不显示为总页数

    $show = $Page->show();// 分页显示输出
    // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
    $limit = $Page->firstRow.','.$Page->listRows;
    $resultAll       = D('SelfView')->getAll($where,$limit);
    $this->resultAll = stringDate($resultAll,'time');//主要数据注入
    $this->assign('page',$show);// 赋值分页输出



    //注入最新动态
    $news = $this->_getNews($id);
    $this->newsCount = count($news);//注入总共有多少条记录
    $this->news = $news;//这里只注入了7条



   //注入最热的10条微博数据
   $this->hotwb = $this->_getHotWB();
    




    $this->display();
  }























/**
 * 微博@用户点击链接处理
 */
//空方法,作用就是 当地址为 Home/Index/?????不存在此控制器的时候 就执行这个方法
  Public function _empty($name){
    $this->_getUrl($name);
  }

  //将获取的用户名转换为ID
  Private function _getUrl($name){
    $name = htmlspecialchars($name);
    $where = array('username'=>$name);
    $uid = M('userinfo')->where($where)->getField('uid');
    if(!$uid){//如果没找到@的用户 则跳回到自己的主页
      redirect(U('Index/index'));
    }else{//找到@的用户 这发送一个GET到当前控制器index 方法下
      redirect(__APP__.'/'.$uid);
    }
  }


  //最新动态SQL 语句用于上面调用
  Private function _getNews($id){
    $sql = 'SELECT
                    p.mini,
                    w.content,
                    p.wid
            FROM
                    wb_weibo w,
                    wb_picture p
            WHERE
                    w.uid='.$id.'
            AND
                    p.wid=w.id
            AND
                    w.isturn=0
            ORDER BY
                    w.time DESC
            LIMIT
                    6';
    $db = M('weibo')->query($sql);
    return $db;
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