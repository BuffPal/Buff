<?php
  namespace Admin\Controller;
  use Admin\Controller;
Class VideoController extends CommonController{

  //分类列表
  Public function classify(){
    //注入分类
    $cate = M('videoclassify')->field(array('name','id','fid'))->select();
    $cate = unlimitedForLevel($cate);
    $this->classifyLists = $cate;
    $this->display();
  }

  //添加分类
  Public function addClassify($id=0,$name=''){
    //注入点击的ID
    if(isset($id)){
      $this->id = $id;
      $this->name = $name;
    }
    $this->display();
  }

  //修改分类页面
  Public function reviseClassify($id=''){
    //执行保存语句
    if(!empty($_POST)){
      //执行添加语句
      if(M('videoclassify')->save($_POST)){
        $this->success('更新成功,正在跳回分类列表页',U('classify'),'1');
      }else{
        $this->error('服务器正忙,请稍后重试');
      }
      return true;
    }
    $classify = M('videoclassify')->where(array('id'=>$id))->field(array('name','id','info','faceurl','fid','faceurl100x150'))->find();
    $this->classify = $classify;
    $this->fid = M('videoclassify')->where(array('id'=>$classify['fid']))->field(array('name','id'))->find();
    $this->display();
  }

  //视频列表
  Public function index(){
    //注入全部栏目用于查找
    $cate = M('videoclassify')->field(array('name','id','fid'))->select();
    $cate = unlimitedForLevel($cate,'--');
    $this->classifyLists = $cate;


    $where = array();
    //这里判断一下后台页面提交过来的两个form表单,这里处理下(一个是用栏目查询,一个是关键字查询)
    if(!empty($_POST)){
      $type = I('type');
      $kaiguan = false;
      switch ($type) {
        case $type=='classify':
          //判断是否为默认
          if(I('cid','','intval') !=0){
            //这里判断也要使用递归找到他下面的所有分类的ID getChildsID();
            //先获取全部classify
            $cate   = M('videoclassify')->field(array('id','fid'))->select();
            $cate   = getChildsID($cate,I('cid','','intval'));//第一个参数为全部数据,第二个为你要父ID等于它的
            //函数内部不压fid这里在重新给他压进去
            $cate[] = I('cid','','intval');
            $cate   = implode(',',$cate);
            $where = array('videoclassify.id'=>array('in',$cate));
            //因为这里跑去 videocalssify 表去查询了所以下麦呢$count 找不到数据 这里还是做一个开关吧
            $kaiguan =true;
            $count = M('video')->where(array('cid'=>array('in',$cate)))->count('id');
          }
          break;
        case $type=='keyword':
          $where = array('videoname'=>array('like','%'.I('keyword').'%'));
          //写入session用于加红
          $this->keyword = I('keyword');
          break;        
        default:
          $where = array();
          break;
      }
    }
    


    //调用分页
    $db    = M('video');
    if(!$kaiguan){
      $count = $db->where($where)->count('id');
    }
    $Page  = new \Think\Page($count,C('VIDEO_LISTS_SIZE'));// 实例化分页类 传入总记录数和每页显示的记录数(2)
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

    //注入结果
    $resultAll = D('VideoView')->getAll($where,$limit);
    $this->assign('page',$show);// 赋值分页输出
    $this->resultAll = $resultAll;

    //判断当前是否是点击类名过来的如果是给他注入
    if(I('cid','','intval')){
      $this->classifyId = I('cid','','intval');
    }

    $this->display();
  }

  //视频操作
  Public function op(){
    $id = I('id','','intval');
    //判断是否是提交过来的
    if(!empty($_POST)){
      //修改注入当前操作管理员的ID
      $_POST['mid']=session('mid');
      if(M('video')->save($_POST)){
        $this->success('更改成功~',U('index'),3);
        die;
      }else{
        $this->error('服务器正忙,请稍后重试','',1);
        die;
      }

    }
    //注入栏目分类
    $cate = M('videoclassify')->field(array('name','id','fid'))->select();
    $cate = unlimitedForLevel($cate,'--');
    $this->classifyLists = $cate;    


    //去数据库检索吧
    $resultAll = D('VideoView')->getAll(array('vid'=>$id));
    $this->video = $resultAll[0];    
    $this->display();
  }

  //视频发布
  Public function add(){
    if(!empty($_POST)){//如果是表单提交过来的话
      //执行自动验证
      $video = new \Admin\Model\VideoModel();
      if($data = $video->create()){
        //注入当前上传时间戳
        $data['uploadtime']=time();
        //注入当前用户ID
        $data['mid']=session('mid');
        //获取当前上传视频的URL用于失败后删除它
        $path = '.'.$data['videourl'];
        if(M('video')->add($data)){
          $this->success('上传成功~!',U('index'),2);
          die;
        }else{
          //删除上传的视频
          @unlink($path);
          $this->error('服务器正忙,请稍后重试','',1);
          die;
        }

      }else{
        $this->error($video->getError(),'',1);
      }
      
    }
    //注入分类
    $cate = M('videoclassify')->field(array('name','id','fid'))->select();
    $cate = unlimitedForLevel($cate,'--');
    $this->classifyLists = $cate;


    $this->display();
  }

  /**
   * AJAX添加类名处理
   */
  Public function addClassify6(){
    if(!IS_POST) E('页面不存在~',404);
    /*添加到数据库*/
    $name = I('name');
    $info = I('info');
    if(mb_strlen($name)>=20){
      $this->error('请保证分类名称在20位之内');
    }
    if(mb_strlen($info)>=70){
      $this->error('请保证简介在70字之内');
    }
    if($id = M('videoclassify')->add($_POST)){
      $this->success('添加成功,正在跳转回分类列表~',U('classify'));
    }else{
      $this->error('服务器正忙,请稍后重试~');
    }
  }


/**
 * index页面删除视频操作
 */
Public function deleteVideo(){
  if(!IS_AJAX) E('页面不存在~',404);
  //在删除之前先找到它 保存的两张图片 和视频地址
  $where = array('id'=>I('id','','intval'));
  $oldData = M('video')->where($where)->field(array('videopicurl','videopicurl176','videourl'))->find();
  //执行删除
  if(M('video')->where($where)->delete()){
    //执行删除源文件
    @unlink('.'.$oldData['videopicurl']);
    @unlink('.'.$oldData['videopicurl176']);
    @unlink('.'.$oldData['videourl']);
    echo json_encode(array('status'=>1,'msg'=>'删除成功~'));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
  }
}


/**
 * index页面删除视频操作
 */
Public function deleteClassify(){
  if(!IS_AJAX) E('页面不存在~',404);
  //判断当前栏目下是否还存在视频,如果存在不能给他删除
  $count = M('videoclassify')->field(array('id','fid'))->select();
  $cate  = getChildsID($count,I('id','','intval'));
  $cate[]= I('id','','intval');
  $cate  = implode(',',$cate);
  $where1 = array('cid'=>array('in',$cate));
  if($countID = M('video')->where($where1)->count('id')){
    echo json_encode(array('status'=>0,'msg'=>'您不能删除此栏目,因当前栏目还有'.$countID.'个视频'));
    die;
  }


  //执行删除
  $where = array('id'=>I('id','','intval'));
  //在删除之前先找到它 保存的两张图片 和视频地址
  $oldData = M('videoclassify')->where($where)->field(array('faceurl','faceurl100x150'))->find();
  if(M('videoclassify')->where($where)->delete()){
    //执行删除源文件
    @unlink('.'.$oldData['faceurl']);
    @unlink('.'.$oldData['faceurl100x150']);
    echo json_encode(array('status'=>1,'msg'=>'删除成功~'));
  }else{
    echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
  }
}

  
}