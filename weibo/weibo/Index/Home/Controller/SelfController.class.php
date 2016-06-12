<?php 
namespace Home\Controller;
Class SelfController extends CommonController{
     //我的首页视图
  Public function index(){
    $this->operationWeibo = U('operationWeibo');//转发跳转地址
    //获取用户个人信息
    $field = array('username','face','intro','follow','fans','weibo','uid');
    $where = array('uid'=>$_SESSION['uid']);
    $this->userinfo = M('userinfo')->field($field)->where($where)->find();//发送数组data过去
    $this->group = M('group')->where(array('uid'=>session('uid')))->select();
    

    //注入最火信息
    $this->hotwb = $this->_getHotWB();


    //获取用户微博 和 关注的用户的微博
    $uid = array(session('uid'));
    //获得用户关注的ID 这里是为了循环出关注用户与用户本身的微博
    $followId = M('follow')->where(array('fans'=>session('uid')))->field(array('follow'))->select();
    if($followId){
      foreach($followId as $v){
        $uid[] = $v['follow'];
      }
    }
    //定义查询条件    //这里IN就查询数组 里面的所有值  多表查询
    $whereAll = array('uid'=>array('IN',$uid));
    //调用视图模型 里面定义的查询条件
    $limit = '0,10';
    $resultAll = D('SelfView')->getAll($whereAll,$limit);
    $this->resultAll = stringDate($resultAll,'time');//这里是一个把时间转换为 刚刚
    $this->_interest();//注入附近感兴趣的人
    $this->display();
  }

  /**
   * 点击组名 切换组里面的用户
   */
  Public function getGid(){
    if(!IS_AJAX) E('页面丢失了~',404);
    $gid = I('gid','','intval');
    $db  = M('follow');
    $uid = array(session('uid'));
    if(empty($gid)){//这里是判断gid是否为0  为0就是显示全部
      $fid = $db->where(array('fans'=>session('uid')))->field('follow')->select();
      foreach($fid as $v){
        $uid[] = $v['follow'];
      }
    }else{//这里是点击组名 获取gid 去数据库取数据
      $fid = $db->where(array('gid'=>$gid))->field('follow')->select();
      foreach($fid as $v){
        $uid[] = $v['follow'];
      }
    }

    $whereAll = array('uid'=>array('IN',$uid));
    $resultAll = D('SelfView')->getAll($whereAll,'10');//获得10条视图模型里面的数据
    $htmlAll;
    foreach($resultAll as $k=>$v){//这里是 循环10条limit  用于变成 html数据
      $v['timeStr'] = format_date($v['time']);
      $v['time'] = date('Y-m-d H:i:s',$v['time']);
      $v['content'] = replace_weibo($v['content']);
    if($v['isturn']){//这里是转发的微博
      $v['isturn']['content'] = replace_weibo($v['isturn']['content']);
      $v['isturn']['time'] = date('Y-m-d H:i:s',$v['isturn']['time']);
      $v['isturn']['count'] = M('comment')->where(array('wid'=>$v['isturn']['id']))->count();//原微博评论读取
      $v['count'] = M('comment')->where(array('wid'=>$v['id']))->count();//评论读取
      $htmlAll.=$this->ajaxHtmlIsturn($v);
    }else{//这里是普通微博
      $v['count'] = M('comment')->where(array('wid'=>$v['id']))->count();
      $htmlAll.=$this->ajaxHtml($v,false);
    }
    }
    if($htmlAll){ 
      echo json_encode(array('status'=>1,'html'=>$htmlAll));//返回ajax
    }else{
      echo json_encode(array('status'=>0,'msg'=>'没数据了'));//返回ajax
    }
  }

  /**
   * keep 用户收藏处理
   */
  Public function keep(){
    if(!IS_AJAX) E('页面丢失了~',404);
    $wid = I('wid','','intval');
    $data = array(
      'wid'=>$wid,
      'uid'=>session('uid'),
      'time'=>time()
      );
    //在插入之前先判断是否已经 收藏了
    if(M('keep')->where(array('wid'=>$wid,'uid'=>session('uid')))->getField('id')){
      echo json_encode(array('status'=>0,'msg'=>'您已经收藏过了~'));
      die;
    }
    if(M('keep')->data($data)->add()){
      echo json_encode(array('status'=>1,'msg'=>'收藏成功~'));
    }

  }

  /**
   * 前台删除微博 delete
   */
  Public function deleteWb(){
    if(!IS_AJAX) E('页面丢失了~',404);
    $wid = I('wid','','intval');
    if(M('weibo')->where(array('id'=>$wid))->delete()){
      //判断是否 在服务器上存的有图片
      $field = array('mini','medium','max');
      if($face = M('picture')->where(array('wid'=>$wid))->field($field)->find()){
        @unlink('.'.$face['mini']);
        @unlink('.'.$face['medium']);
        @unlink('.'.$face['max']);
      }
      echo json_encode(array('status'=>1,'msg'=>'删除成功~'));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙.请稍后再试'));
    }
  }


  //微博提交 异步处理
  Public function sendWeiBo(){
    if(!IS_AJAX) E('页面丢失了~',404);
    $dataWb = array(
        'content'=>I('content'),
        'time'=>time(),
        'uid'=>session('uid')
      );
    if($wid = M('weibo')->data($dataWb)->add()){//这里先插入数据,下面在插入配图表,节省资源,这里插入后返回ID
      //@用户处理
      $this->_atmeAdd($dataWb['content'],$wid);

      if(I('max')){//存在配图 开始插入
        $dataPic = array(
            'mini'=>I('mini'),
            'medium'=>I('medium'),
            'max'=>I('max'),
            'wid'=>$wid
          );
        if(M('picture')->data($dataPic)->add()){//插入配图成功
          $data = $this->_getNewInsert($wid);
          $data = $this->ajaxHtml($data);
          M('userinfo')->where(array('uid'=>session('uid')))->setInc('weibo');//用户的微博量加1
          echo json_encode(array('status'=>1,'msg'=>'发布成功','html'=>$data));
        }else{//插入配图表失败
          echo json_encode(array('status'=>0,'msg'=>'发布失败,请重新尝试~'));
        }
      }else{//配图不存在时候  插入成功提示
        $data = $this->_getNewInsert($wid);
        $data = $this->ajaxHtml($data);
        M('userinfo')->where(array('uid'=>session('uid')))->setInc('weibo');//用户的微博量加1
        echo json_encode(array('status'=>1,'msg'=>'发布成功','html'=>$data));
      }
    }else{
      echo json_encode(array('status'=>0,'msg'=>'发布失败,请重新尝试~'));
    }
  }

  /**
   * 内容 @用户添加处理
   */
  Private function _atmeAdd($content,$wid){
    $preg = '/@(\S+?)\s/is';
    preg_match_all($preg,$content,$arr);
    if($arr[1]){//判断 all里面有没有匹配到值
      $db = M('userinfo');
      $at = M('atme');
      foreach($arr[1] as $v){
        //获取@用户的 ID
        $uid = $db->where(array('username'=>$v))->getField('uid');
        if($uid){//判断@的用户是否存在? 
          //写入数据库
          $data = array(
              'uid' => $uid,
              'wid' => $wid
            );
          $at->data($data)->add();//插入@表
        }
      }
    }

  }

  //微博转发提交处理
Public function operationWeibo(){
  if(!IS_POST) E('页面不存在~',404);
  $wid = I('wid','','intval');
  $tid = I('tid','','intval');//这里是多次转发的时候才会有
  $data = array(//插入转发数据
                'isturn'  =>$tid ? $tid : $wid,//这里判断 是第一次转发 还是多次转发
                'content' =>I('operationContento'),
                'time'    =>time(),
                'uid'     =>session('uid')
                );
  $db = M('weibo');
  //这个是把用户转发的 @取出来 不取转发@的
  $arr = explode('//',$data['content']);;
  if($wid = $db->data($data)->add()){
    //@用户 这里需要处理下 因为是转发会多次@
    $this->_atmeAdd($arr[0],$wid);
    if($tid){//如果是多转发的话,给原微博也加一次
      $db->where(array('id'=>$tid))->setInc('turn');//成功后原微博转发次数加1
    }
    $db->where(array('id'=>$wid))->setInc('turn');//成功后原微博转发次数加1
    M('userinfo')->where(array('uid'=>session('uid')))->setInc('weibo');//用户的微博量加1
    $this->success('转发成功~',U('index'));
  }else{
    $this->error('转发失败,请稍后再试~',U('index'));
  }
}

//注入微博评论 列表 
Public function getComentAll(){
  if(!IS_AJAX) E('页面不存在~',404);
  $result = D('SelfCommentView')->getCommentAll(array('wid'=>I('wid')));
  $count  = M('comment')->where(array('wid'=>I('wid')))->count();//返回当前有多少评论
  $html;
  foreach($result as $v){
    $html .= $this->_commentAll($v);
  };
  echo json_encode(array('data'=>$html,'count'=>$count));
}


//微博评论处理AJAX
Public function Comment(){
  if(!IS_AJAX) E('页面不存在~',404);
  $data = array(
    'wid'=>I('wid'),
    'uid'=>session('uid'),
    'content'=>I('content'),
    'time'=>time()
    );
  if($id = M('comment')->data($data)->add()){
    $data = M('userinfo')->where(array('uid'=>session('uid')))->field(array('face','username','uid'))->find();
    $userinfo = M('weibo')->where(array('id'=>I('wid')))->setInc('comment');//该文档评论+1
    $json = $this->_commentHtml($data,$id);
    echo json_encode(array('status'=>1,'msg'=>'评论成功~','data'=>$json));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试~'));
  }
}

//滚动条距离移动到底部 动态添加 AJAX数据 返回json
Public function ajaxData(){
  if(!IS_AJAX) E('页面不存在~',404);
  sleep(1);
  $limit = I('limit');
  $gid   = I('gid','','intval');
  $db    = M('follow');
  $uid   = array(session('uid'));//一下是复制过来的
    //获得用户关注的ID 这里是为了循环出关注用户与用户本身的微博
  if(empty($gid)){//这里是判断gid是否为0  为0就是显示全部
      $followId = M('follow')->where(array('fans'=>session('uid')))->field(array('follow'))->select();
      $fid = $db->where(array('fans'=>session('uid')))->field('follow')->select();
      foreach($followId as $v){
        $uid[] = $v['follow'];
      }
    }else{//这里是点击组名 获取gid 去数据库取数据
      $fid = $db->where(array('gid'=>$gid))->field('follow')->select();
      foreach($fid as $v){
        $uid[] = $v['follow'];
      }
    }

    //定义查询条件    //这里IN就查询数组 里面的所有值  多表查询
  $whereAll = array('uid'=>array('IN',$uid));
    //调用视图模型 里面定义的查询条件
  $limit = $limit.',10';//$limit 是前台AJAX返回出来的 当前页面有多少条微博 (就是ui里面有多少Li)
  $resultAll = D('SelfView')->getAll($whereAll,$limit);
  $htmlAll;
  foreach($resultAll as $k=>$v){//这里是 循环10条limit
    $v['timeStr'] = format_date($v['time']);
    $v['time'] = date('Y-m-d H:i:s',$v['time']);
    $v['content'] = replace_weibo($v['content']);
    if($v['isturn']){//这里是转发的微博
      $v['isturn']['content'] = replace_weibo($v['isturn']['content']);
      $v['isturn']['time'] = date('Y-m-d H:i:s',$v['isturn']['time']);
      $v['isturn']['count'] = M('comment')->where(array('wid'=>$v['isturn']['id']))->count();//原微博评论读取
      $v['count'] = M('comment')->where(array('wid'=>$v['id']))->count();//评论读取
      $htmlAll.=$this->ajaxHtmlIsturn($v);
    }else{//这里是普通微博
      $v['count'] = M('comment')->where(array('wid'=>$v['id']))->count();
      $htmlAll.=$this->ajaxHtml($v,false);
    }
  }
  if($htmlAll){ 
    echo json_encode(array('status'=>1,'html'=>$htmlAll));//返回ajax
  }else{
    echo json_encode(array('status'=>0,'msg'=>'没数据了'));//返回ajax
  }
}

//前台点赞 AJAX处理方法
  Public function praiseAjax(){
    if(!IS_AJAX) E('页面不存在~',404);
    if(M('weibo')->where(array('id'=>I('wid')))->setInc('praise')){//+1
      echo json_encode(array('status'=>1,'msg'=>'点赞成功'));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
    };
  }

/**
 * 用户收藏列表 keepList
 */
Public function keepList(){
  $this->operationWeibo = U('operationWeibo');//转发跳转地址
  //获取用户个人信息
  $field = array('username','face','intro','follow','fans','weibo','uid');
  $where = array('uid'=>$_SESSION['uid']);
  $this->userinfo = M('userinfo')->field($field)->where($where)->find();//发送数组data过去
  $this->group = M('group')->where(array('uid'=>session('uid')))->select();
  

  //注入最火信息
  $this->hotwb = $this->_getHotWB();

  //注入收藏的微博
  $count = M('keep')->where(array('uid'=>session('uid')))->count('id');// 查询满足要求的总记录数
  if(!empty($count)){//如果用户没有关注
    $Page  = new \Think\Page($count,C('INDEX_SERCH_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
    $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
    $Page->setConfig('prev', '上一页');
    $Page->setConfig('next', '下一页');
    $Page->setConfig('last', '末页');
    $Page->setConfig('first', '首页');
    $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $Page->lastSuffix = false;//最后一页不显示为总页数

    $show = $Page->show();// 分页显示输出
    $where = array('keep.uid'=>session('uid'));
    $limit = $Page->firstRow.','.$Page->listRows;
    $keepView = D('KeepView');//收藏视图模型
    $result = $keepView->getAll($where,$limit);
    $result = stringDate($result,'time');
    $this->resultAll = $result;
    $this->assign('page',$show);// 赋值分页输出
  }
  $this->display();
}


/**
 * 取消收藏处理
 */
Public function unKeep(){
  if(!IS_AJAX) E('页面不存在~',404);
  $wid = I('wid','','intval');
  $uid = session('uid');
  if(M('keep')->where(array('wid'=>$wid,'uid'=>$uid))->limit('1')->delete()){
    echo json_encode(array('status'=>1,'msg'=>'取消成功~'));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
  }
}


/**
 * 用户私信列表
 */
Public function callMeList(){
  $this->operationWeibo = U('operationWeibo');//转发跳转地址
  //获取用户个人信息
  $field = array('username','face','intro','follow','fans','weibo','uid');
  $where = array('uid'=>$_SESSION['uid']);
  $this->userinfo = M('userinfo')->field($field)->where($where)->find();//发送数组data过去
  $this->group = M('group')->where(array('uid'=>session('uid')))->select();
  
  //注入最火信息
  $this->hotwb = $this->_getHotWB();

  //私信分页
  $where = array('uid'=>session('uid'));
  $count = M('letter')->where($where)->count('id');
  $this->callCount = $count;//注入总条数
  if($count){//为空报错处理
    $Page  = new \Think\Page($count,C('INDEX_SERCH_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
    $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
    $Page->setConfig('prev', '上一页');
    $Page->setConfig('next', '下一页');
    $Page->setConfig('last', '末页');
    $Page->setConfig('first', '首页');
    $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $Page->lastSuffix = false;//最后一页不显示为总页数

    //注入私信
    $show = $Page->show();// 分页显示输出
    $limit = $Page->firstRow.','.$Page->listRows;
    $field = array('id','from','content','time');
    $result = M('letter')->where($where)->field($field)->order('time DESC')->limit($limit)->select();
    //循环 $result[$k][from] 查询userinfo里面的用户信息
    foreach($result as $k=>$v){
      $result[$k]['from'] = M('userinfo')->where(array('uid'=>$v['from']))->field(array('username','face','uid'))->find();
    }
    $result = stringDate($result,'time');
    $this->callAll = $result;
    $this->assign('page',$show);// 赋值分页输出
  }
  $this->display();
}

/**
 * 判断用户名时候存在(ajax 判断 name)
 */
Public function checkName(){
  if(!IS_AJAX) E('页面不存在~',404);
  $name = I('name');
  if($fid = M('userinfo')->where(array('username'=>$name))->getField('uid')){
    if($fid == session('uid')){
      echo json_encode(array('status'=>0,'msg'=>'不能发给自己'));
      die;
    }
    echo json_encode(array('status'=>1,'fid'=>$fid));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'用户不存在!~'));
  }
}

/**
 * 发送私信AJAX处理
 */
Public function sendCall(){
  if(!IS_AJAX) E('页面不存在~',404);
  $from    = session('uid');//这里写反了改下
  $content = I('content');
  $time    = time();
  $uid     = I('from','','intval');
  $data = array(
    'from'=>$from,
    'content'=>$content,
    'time'=>$time,
    'uid'=>$uid
    );
  if(M('letter')->data($data)->add()){
    echo json_encode(array('status'=>1,'msg'=>'发送成功~'));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
  }
}

/**
 * 删除私信处理
 */
Public function callDelete(){
  if(!IS_AJAX) E('页面不存在~',404);
  $id = I('id','','intval');
  if(M('letter')->where(array('id'=>$id))->delete()){
    echo json_encode(array('status'=>1,'msg'=>'删除成功~'));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
  }
}

/**
 * 评论列表
 */
Public function commentList(){
  $this->operationWeibo = U('operationWeibo');//转发跳转地址
  //获取用户个人信息
  $field = array('username','face','intro','follow','fans','weibo','uid');
  $where = array('uid'=>$_SESSION['uid']);
  $this->userinfo = M('userinfo')->field($field)->where($where)->find();//发送数组data过去
  $this->group = M('group')->where(array('uid'=>session('uid')))->select();
  
  //注入最火信息
  $this->hotwb = $this->_getHotWB();

  //评论分页
  $where = array('uid'=>session('uid'));
  $count = M('comment')->where($where)->count('id');
  $this->callCount = $count;//注入总条数
  if($count){//为空报错处理
    $Page  = new \Think\Page($count,C('INDEX_SERCH_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
    $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
    $Page->setConfig('prev', '上一页');
    $Page->setConfig('next', '下一页');
    $Page->setConfig('last', '末页');
    $Page->setConfig('first', '首页');
    $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $Page->lastSuffix = false;//最后一页不显示为总页数

    //注入私信
    $show   = $Page->show();// 分页显示输出
    $limit  = $Page->firstRow.','.$Page->listRows;
    $db = D('SelfCommentView');
    $resultAll = $db->getCommentAll($where,$limit);
    $this->callAll = $resultAll;
    $this->assign('page',$show);// 赋值分页输出
  }
  $this->display();
}

/**
 * 删除评论方法
 */
Public function deleteComment(){
  if(!IS_AJAX) E('页面不存在~',404);
  $id = I('id','','intval');
  $where = array('id'=>$id);
  if(M('comment')->where($where)->delete()){
    echo json_encode(array('status'=>1,'msg'=>'删除成功~'));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
  }
}

/**
 * @我的处理
 */
Public function atmeList(){
  $this->type = 'comment';//因为调用的是 和收藏同一个模板 这里用这个type在模板中进行判断
  $this->operationWeibo = U('operationWeibo');//转发跳转地址
  //获取用户个人信息
  $field = array('username','face','intro','follow','fans','weibo','uid');
  $where = array('uid'=>$_SESSION['uid']);
  $this->userinfo = M('userinfo')->field($field)->where($where)->find();//发送数组data过去
  $this->group = M('group')->where(array('uid'=>session('uid')))->select();
  

  //注入最火信息
  $this->hotwb = $this->_getHotWB();

  //注入@我的微博
  $wids = M('atme')->where(array('uid'=>session('uid')))->field('wid')->select();
  $wids = TwoArrToOneArr($wids,'wid');//这里用IN条件 视图模型为SelfView
  $count = count($wids);
  if(!empty($count)){//如果没有@ 报错处理
    $Page  = new \Think\Page($count,C('INDEX_SERCH_PAGE_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
    $Page->setConfig('header', '<li class="rows">共<b>%TOTAL_ROW%</b>条记录&nbsp;</li>');//page样式定义
    $Page->setConfig('prev', '上一页');
    $Page->setConfig('next', '下一页');
    $Page->setConfig('last', '末页');
    $Page->setConfig('first', '首页');
    $Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
    $Page->lastSuffix = false;//最后一页不显示为总页数

    $show = $Page->show();// 分页显示输出
    $where = array('id'=>array('IN',$wids));
    $limit = $Page->firstRow.','.$Page->listRows;
    $SelfView = D('SelfView');
    $result = $SelfView->getAll($where,$limit);
    $result = stringDate($result,'time');
    $this->resultAll = $result;
    $this->assign('page',$show);// 赋值分页输出
  }
  $this->display('keepList');
}

/**
 * 删除@me的处理
 */
Public function deleteat(){
  if(!IS_AJAX) E('页面不存在~',404);
  $where = array('wid'=>I('wid','','intval'),'uid'=>session('uid'));
  if(M('atme')->where($where)->delete()){
    echo json_encode(array('status'=>1,'msg'=>'清除成功~'));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
  }
}


/**
 * changebg
 */
Public function changebg(){
  if(!IS_AJAX) E('页面不存在~',404);
  $data = array('style'=>I('style'));
  if(M('userinfo')->where(array('uid'=>session('uid')))->data($data)->save()){
    echo json_encode(array('status'=>1,'msg'=>'保存成功~'));
  }else{
    echo json_encode(array('status'=>1,'msg'=>'服务器正忙,请稍后重试'));
  }
}



/**
 * 获取AJAX返回添加的 Html 代码         这个是不带转发的
 * @param  [Array] $data [插入的数组]
 * @param  [布尔]  $status [判断是否需要添加liClassanimate]
 * @return [Array]       [返回的array]
 */
  private function ajaxHtml($data,$status = true){
    $html;
    if($status){//判断是时候是添加博客读取 或者是AJAX滚动条读取
      $html.='<li class="liClassanimate">';
    }else{
      $html.='<li>';
    }
    $html.='<a href="'.U('/'.$data['uid']).'" class="blogUserPica">';
    if(!empty($data['face'])){//判断用户是否长传头像
      $html.='<img src="'.__ROOT__.$data['face'].'" class="blogUserPic">';//用户头像  
    }else{
      $html.='<img src="__PUBLIC__/images/none.png" class="blogUserPic">';//用户头像  
    }
    $html.='</a>';
    $html.='<article class="excerpt">';//主要内容开始
    $html.='<header>';
    $html.='<h4 class="userIFM" value="'.$data['uid'].'">';
    $html.='<a href="'.U('/'.$data['uid']).'" class="userName">'.$data['username'].'</a>';//用户名
    $html.='<a href="#" class="userLevel"><i class="icon-award8"></i></a>';//用户等级勋章 没啥用
    $html.='<a class="deleteWB" wid="'.$data['id'].'">删除</a>';
    $html.='</h4>';//下面是发表时间 和时间隐藏域
    if($data['timeStr']){//判断 时候是AJAX添加的微博,这里有个BUG 需要判断下,_getNewInsert()取不到timeStr
      $html.='<div class="timeIFM"><i class="icon-clock"> '.$data['timeStr'].'　　<span class="hiddenTime">'.$data['time'].'</span>';
    }else{
      $html.='<div class="timeIFM"><i class="icon-clock"> 刚刚　<span class="hiddenTime">'.$data['time'].'</span>';
    }
    $html.='</i>来自可以防弹的手机</div>'; //这个没啥用
    $html.='</header>';
    $html.='<p class="blogContent">'.$data['content'].'</p>';//发表的主要内容 涉及到替换表情
    $html.='<div class="userUploadImg">';
    if(!empty($data['mini'])){
      $html.='<img src="'.__ROOT__.$data["max"].'" data-action="zoom">';//用户发表微博的配图,      这里需要判断一下是否有
    }
    $html.='</div>';
    $html.='<footer>';
    $html.='<ul class="operation">';
    $html.='<li><a href="#" wid="'.$data['id'].'" class="keep"><i class="icon-star-empty">　<span>　收藏</span></i></a></li>';//收藏按钮
    $html.='<li><a href="#" class="operation" id="'.$data['id'].'"><i class="icon-redo2">　<span>'.$data['turn'].'</span></i></a></li>';//转发人数
    $html.='<li><a href="#" class="praiseE" wid="'.$data['id'].'"><i class="icon-fire">　<span>'.$data['praise'].'</span></i></a></li>';//点赞人数
    $html.='<li><a href="#" class="commentE" wid="'.$data['id'].'"><i class="icon-chat">　<span>'.$data['count'].'</span></i></a></li>';//评论人数
    $html.='</ul></footer></article>';//结尾标签
    $html.='<div class="comment">';
    $html.='<div class="publish">';
    $html.='<div class="input">';
    if($data['face']){//这里要获取当前session的id 就用户的ID
      $face = M('userinfo')->where(array('uid'=>session('uid')))->getField('face');
      $html.='<img src="'.__ROOT__.$face.'">';
    }else{
      $html.='<img src="'.__ROOT__.'/Public/images/none.png">';
    }
    $html.='<input type="text" name="comment" id="'.$data['id'].'" sign="phiz'.$data['id'].'">';
    $html.='</div>';
    $html.='<div class="phiz">';
    $html.='<i class="icon-smile" id="icon-smileComment" name="reply" sign="phiz'.$data['id'].'"></i>';
    $html.='<span class="commentE">评论</span>';
    $html.='</div>';
    $html.='</div>';
    $html.='<div class="animate"><i class="icon-spinner6"></i></div>';
    $html.='<div class="list_ul">';
    $html.='</div>';
    $html.='<div class="moreReply"><a href="'.U('Discuss/index',array('wid'=>$data['id'])).'" target="_blank"></a></div>';
    $html.='</li>';
    return $html;
  }


//获取sendWeiBo()添加成功 查询出来数据(userinfo,weibo,picture)表 用来返回Ajax  这里就不用关联表了
private function _getNewInsert($wid){
  $userinfo = M('userinfo')->where(array('uid'=>session('uid')))->field(array('username','face'))->find();
  $data = array();
  $data['turn']     = 0;
  $data['praise']   = 0;
  $data['count']    = 0;
  $data['content']  = replace_weibo(I('content'));
  $data['time']     = date("Y-m-d H:i:s");
  $data['username'] = $userinfo['username'];
  $data['face']     = $userinfo['face'];
  $data['id']       = $wid;
  $data['uid']      = session('uid');
  $data['mini']     = I('mini');
  $data['max']      = I('max');
  return $data;
}


 //退出登录处理
  public function logout(){
    //卸载SESSION
    session_unset();
    session_destroy();

    //删除cookie
    setcookie('auto','',time()-1,'/');
    header('Content-Type:text/html;Charset=UTF-8');
    redirect(U('Login/index'),1,'正在跳转回登录页');
  }



  /**
   * 少年不考虑周到,老大哭着改BUG
   * @param  [type] $data [需要传入的数据]
   * @return [type]       [description]
   */
  private function ajaxHtmlIsturn($data){
    $html;
    $html.='<li class="forwarding">';
    $html.='<a href="'.U('/'.$data['uid']).'" class="blogUserPica" target="_blank">';
    if(!empty($data['face'])){//判断用户是否长传头像
      $html.='<img src="'.__ROOT__.$data['face'].'" class="blogUserPic">';//用户头像  
    }else{
      $html.='<img src="__PUBLIC__/images/none.png" class="blogUserPic">';//用户头像  
    }
    $html.='<article class="excerpt">';
    $html.='<header>';
    $html.='<h4 class="userIFM" value="'.$data['uid'].'">';
    $html.='<a href="'.U('/'.$data['uid']).'" class="userName"  target="_blank">'.$data['username'].'</a>';
    $html.='<a href="#" class="userLevel"><i class="icon-award8"></i></a>';
    $html.='<a class="deleteWB" wid="'.$data['id'].'">删除</a>';
    $html.='</h4>';
    $html.='<div class="timeIFM"><i class="icon-clock"> '.$data['timeStr'].'　　<span class="hiddenTime">'.$data['time'].'</span></i>来自可以防弹的手机</div>';
    $html.='</header>';
    $html.='<p class="blogContent">'.$data['content'].'</p>';
if($data['isturn'] == -1){
      $html.='<span class="deleteNotWb">用户转发的微博已被删除~</span>';
}else{
    $html.='<div class="userforwarding">';
    $html.='<h4 class="userIFM">';
    $html.='<a href="'.U('/'.$data['isturn']['uid']).'" class="userNameisturn" name="'.$data['isturn']['uid'].'" target="_blank">'.$data['isturn']['username'].'</a>';
    $html.='<a href="#" class="userLevel"><i class="icon-award8"></i></a>';
    $html.='</h4>';
    $html.='<p class="forwardingContent">'.$data['isturn']['content'].'</p>';
    $html.='<div class="forwardingUploadImg">';
    if($data['isturn']['mini']){
      $html.='<img src="'.__ROOT__.$data['isturn']['max'].'" data-action="zoom">';
    }
    $html.='</div>';
    $html.='<div class="forwardingIFM">';
    $html.='<span class="forwardingTime">'.$data['isturn']['time'].'</span>';
    $html.='<ul class="forwardingCount">';
    $html.='<li><a href="#" class="operation" yid="'.$data['isturn']['id'].'"><i class="icon-redo2"></i>　<span>'.$data['isturn']['turn'].'</span></a></li>';
    $html.='<li><a href="#" class="praiseE" wid="'.$data['isturn']['id'].'"><i class="icon-fire"></i>　<span>'.$data['isturn']['praise'].'</span></a></li>';
    $html.='<li><a href="#"><i class="icon-chat"></i>　<span>'.$data['isturn']['comment'].'</span></a></li>';
    $html.='</ul>';
    $html.='</div>';
    $html.='</div>';
}
    $html.='<footer>';
    $html.='<ul class="operation">';
    $html.='<li><a href="#" wid="'.$data['id'].'" class="keep"><i class="icon-star-empty">　收藏</i></a></li>';
    $html.='<li><a href="#" class="operation" id="'.$data['id'].'" tid="'.$data['isturn']['id'].'"><i class="icon-redo2">　<span>'.$data['turn'].'</span></i></a></li>';
    $html.='<li><a href="#" class="praiseE" wid="'.$data['id'].'"><i class="icon-fire">　<span>'.$data['praise'].'</span></i></a></li>';
    $html.='<li><a href="#" class="commentE" wid="'.$data['id'].'"><i class="icon-chat">　<span>'.$data['comment'].'</span></i></a></li>';
    $html.='</ul>';
    $html.='</footer>';
    $html.='</article>';
    $html.='<div class="comment">';
    $html.='<div class="publish">';
    $html.='<div class="input">';
    if($data['face']){//这里要获取当前session的id 就用户的ID
      $face = M('userinfo')->where(array('uid'=>session('uid')))->getField('face');
      $html.='<img src="'.__ROOT__.$face.'">';
    }else{
      $html.='<img src="'.__ROOT__.'/Public/images/none.png">';
    }
    $html.='<input type="text" name="comment" id="'.$data['id'].'" sign="phiz'.$data['id'].'">';
    $html.='</div>';
    $html.='<div class="phiz">';
    $html.='<i class="icon-smile" id="icon-smileComment" name="reply" sign="phiz'.$data['id'].'"></i>';
    $html.='<span class="commentE">评论</span>';
    $html.='</div>';
    $html.='</div>';
    $html.='<div class="animate"><i class="icon-spinner6"></i></div>';
    $html.='<div class="list_ul">';
    $html.='</div>';
    $html.='<div class="moreReply"><a href="'.U('Discuss/index',array('wid'=>$data['id'])).'" target="_blank"></a></div>';
    $html.='</li>';
    return $html;
  }


  //评论返回的JSON数据
  private function _commentHtml($u,$id){
    $html;
    $html.='<div class="list_li">';
    if($u['face']){
      $html.='<a href="'.U('/'.$u['uid']).'" class="userFace"><img src="'.__ROOT__.$u['face'].'"></a>';//头像需要判断
    }else{
      $html.='<a href="'.U('/'.$u['uid']).'" class="userFace"><img src="__PUBLIC__/images/none.png"></a>';//头像需要判断
    }
    $html.='<div class="text"><a href="'.U('/'.$u['uid']).'">'.$u['username'].'</a> : '.replace_weibo(I('content')).' </div>';//内容用户名注入
    $html.='<div class="time">';
    if($u['timeStr']){
       $html.='<span class="timeStr">'.$u['timeStr'].'<p>'.$u['time'].'</p></span>';//时间注入
    }else{
       $html.='<span class="timeStr">刚刚<p>'.date('Y-m-d H:i:s',time()).'</p></span>';//时间注入
    }
    $html.='<span class="support"><p class="supportClick">回复</p>　　赞&nbsp;<strong>804</strong></span>';
    $html.='</div>';
    $html.='<div class="reply">';
    $html.='<input type="text" name="reply" class="reply" sign="phiz{$vo.isturn.id}">';
    $html.='<span class="replyByReply">';
    $html.='<i class="icon-smile" sign="phiz'.$id.'"></i>';
    $html.='<span>评论</span>';
    $html.='</span></div></div>';
    return $html;
  }

  /**
   * 获取后台该微博的10条评论信息  
   * @param  [type] $data [description]
   * @return [type]       [description]
   */
  private function _commentAll($data){
    $html;
    $html .='<div class="list_li">';
    if($data['face']){
      $html.='<a href="'.U('/'.$data['uid']).'" class="userFace"><img src="'.__ROOT__.$data['face'].'"></a>';//
    }else{
      $html.='<a href="'.U('/'.$data['uid']).'" class="userFace"><img src="__PUBLIC__/images/none.png"></a>';//
    }
    $html .='<div class="text"><a href="'.U('/'.$data['uid']).'">'.$data['username'].'</a> :  '.$data['content'].'</div>';
    $html .='<div class="time">';
    $html .='<span class="timeStr">'.$data['timeStr'].'<p>'.$data['time'].'</p></span>';
    $html .='<span class="support"><p class="supportClick">回复</p>　　赞&nbsp;<strong>804</strong></span>';
    $html .='</div>';
    $html .='<div class="reply">';
    $html .='<input type="text" name="reply" class="reply" sign="phiz'.$data['id'].'">';
    $html .='<span class="replyByReply">';
    $html .='<i class="icon-smile" sign="phiz'.$data['id'].'"></i>';
    $html .='<span>评论</span>';
    $html .='</span>';
    $html .='</div>';
    $html .='</div>';
    return $html;
  }

   /**
   * 附近感兴趣的人
   */
  Private function _interest(){
      $db  = M('follow');
      $uid = session('uid');
      $fId = $db->where(array('fans'=>$uid))->field(array('follow'))->select();//获取当前自己所关注的用户ID
      if($fId){
      foreach($fId as $k=>$v){
        $fId[$k] = $v['follow'];//压入数组用户 IN
      }
      $inId = implode(',',$fId);
        $sql = 'SELECT
                      u.uid,
                      u.username,
                      u.face,
                      u.location,
                      u.sex,
                      COUNT(f.follow) AS count
                 FROM
                      wb_follow f
            LEFT JOIN
                      wb_userinfo u
                   ON
                      f.follow=u.uid
                WHERE
                      f.fans  IN ('.$inId.')
                  AND
                      f.follow NOT IN ('.$inId.')
                  AND
                      f.follow<>'.$uid.'
             GROUP BY
                      f.follow
             ORDER BY
                      count DESC
                LIMIT
                      4
                      ';
          $this->resultI = $db->query($sql);
          }
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