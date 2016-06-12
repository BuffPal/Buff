<?php 
namespace Admin\Controller;
use Think\Controller;
Class MusicController extends Controller{

  //音乐列表
  Public function index(){
  //注入全部栏目用于查找
    $cate = M('musicclassify')->field(array('id','name','fid'))->select();
    $cate = unlimitedForLayer($cate);
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
            $where = array('cid'=>I('cid','','intval'));
            //因为这里跑去 musiccalssify 表去查询了所以下面呢$count 找不到数据 这里还是做一个开关吧
            $kaiguan =true;
            $count = M('music')->where(array('cid'=>I('cid','','intval')))->count('id');
          }
          break;
        case $type=='keyword':
          $where = array('musicname'=>array('like','%'.I('keyword').'%'));
          //写入session用于加红
          $this->keyword = I('keyword');
          break;        
        default:
          $where = array();
          break;
      }
    }


    //调用分页
    $db    = M('music');
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
    $resultAll = D('MusicView')->getAll($where,$limit);
    $this->assign('page',$show);// 赋值分页输出
    $this->resultAll = $resultAll;

    //判断当前是否是点击类名过来的如果是给他注入
    if(I('cid','','intval')){
      $this->classifyId = I('cid','','intval');
    }
    $this->display();
  }

  //音乐栏目列表
  Public function lists(){
    //注入栏目
    $cate = M('musicclassify')->field(array('name','id','fid'))->select();
    $cate = unlimitedForLevel($cate,'　　');
    $this->classifyLists = $cate;

    $this->display();
  }

  //添加音乐栏目
  Public function addClassify(){
    //判断有没有是不是分类列表点击过来的
    if($id = I('id')){
      //注入一个变量用于给前台JS判断
      $this->getId = $id;
    }
    //执行表单验证
    if(!empty($_POST)){

      //过滤第一级执行
      if(!empty(I('fid','','intval'))){
        //这里需要判断下是否超过了二级,为了前台跟好的显示这里给他判断下;
        $check = M('musicclassify')->where(array('id'=>I('fid','','intval')))->getField('fid');
        //判断是否为0 就知道了 传过来的父类的fid如果是0 就是代表二级 如果不为0就是 第三级以下了;
        if($check != 0){
          $this->error('为了前台更好的显示,现在只支持两级栏目','',3);
        }
      }        

      //执行自动验证
      $music = new \Admin\Model\MusicclassifyModel();
      if($data = $music->create()){
        $path = '.'.$data['faceurl'];
        if(M('musicclassify')->add($data)){
          $this->success('上传成功~!',U('lists'),2);
          die;
        }else{
          //删除上传的视频
          @unlink($path);
          $this->error('服务器正忙,请稍后重试','',1);
          die;
        }

      }else{
        $this->error($music->getError(),'',1);
      }
    }
    //注入父级栏目选择
    $cate = M('musicclassify')->field(array('id','name','fid'))->select();
    $cate = unlimitedForLevel($cate,'　');
    $this->classifyLists = $cate;

    $this->display();
  }

  //添加音乐
  Public function add(){
    //表单提交处理
    if(!empty($_POST)){
      //执行自动验证
      $music = new \Admin\Model\MusicModel();
      if($data = $music->create()){
        //注入当前上传时间戳
        $data['uploadtime']=time();
        //注入当前用户ID
        $data['mid']=session('mid');
        //获取当前上传音乐的URL用于失败后删除它
        $path = '.'.$data['musicurl'];
        if(M('music')->add($data)){
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
    //注入要添加的栏目(这里就不能用unlimitedForLevel 这里需要注入一个二维数组) 这里用optgroup(下拉群组)
    $cate = M('musicclassify')->field(array('id','name','fid'))->select();
    $cate = unlimitedForLayer($cate);
    $this->classifyLists = $cate;


    $this->display();
  }


  //视频操作
  Public function op(){
    $id = I('id','','intval');
    //判断是否是提交过来的
    if(!empty($_POST)){
      //修改注入当前操作管理员的ID
      $_POST['mid']=session('mid');
      if(M('music')->save($_POST)){
        $this->success('更改成功~',U('index'),3);
        die;
      }else{
        $this->error('服务器正忙,请稍后重试','',1);
        die;
      }

    }
    //注入全部栏目用于选择
    $cate = M('musicclassify')->field(array('id','name','fid'))->select();
    $cate = unlimitedForLayer($cate);
    $this->classifyLists = $cate;   

    //去数据库检索吧
    $resultAll = D('MusicView')->getAll(array('music.id'=>$id));
    $this->music = $resultAll[0];    
    $this->display();
  }

  /**
   * 删除音乐处理
   */
  Public function deleteMusic(){
    if(!IS_AJAX) E('页面不存在~',404);
    //在删除之前先找到它 保存的两张图片 和视频地址
    $where = array('id'=>I('id','','intval'));
    $oldData = M('music')->where($where)->field(array('musicbgurl','musicurl'))->find();
    //执行删除
    if(M('music')->where($where)->delete()){
      //执行删除源文件
      @unlink('.'.$oldData['musicbgurl']);
      @unlink('.'.$oldData['musicurl']);
      echo json_encode(array('status'=>1,'msg'=>'删除成功~'));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
    }
  }


}