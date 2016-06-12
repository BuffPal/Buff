<?php 
/**
 * 自动运行类
 */
namespace Home\Controller;
use       Think\Controller;
Class CommonController extends Controller{

  Public function _initialize(){//自动运行函数 用于前台判断用户是否登录
    //处理自动登陆 Cookie
    if(isset($_COOKIE['auto']) && !isset($_SESSION['uid'])){//cookie 存在 并且用户在非登录状态(SESSION没有uid)
      $value = explode('|',encryption($_COOKIE['auto'],1));//拆分客户端cookie 函数在Common里面定义的
      $ip    = get_client_ip();//获取客户端IP地址
      if($ip == $value[1]){//判断当前客户端IP是否等于上次登录保存的IP
        $account = $value[0];
        $where = array('username'=>$account);
        $user = M('user')->where($where)->field('id','locks')->find();//查找当前 cookie 里面的用户名保存 到 SESSION里面
        if($user && !$user['locks']){//判断是否是伪造的account //如果查询不出来表示当前数据库没有该用户
          session('uid',$user['id']);
        }else{
          $this->error('您的账号已被锁定,请联系管理员');
        }
      }
    }

    //判断用户是否已登录
    if(!isset($_SESSION['uid'])) redirect(U('Login/index'));
    //注入导航栏最热的搜索信息
    $this->hotsoso = 'aaaa';
  }

  //异步添加分组 来自搜索页面
  Public function addGroup(){
    if(!IS_AJAX) E('页面不存在~',404);
    $data = array('name'=>I('name'),'uid'=>session('uid'));
    $where = array('name'=>I('name'),'uid'=>session('uid'));
    $db = M('group');
    if($db->where($where)->select()){//判断用户添加的分组时候已经存在
      echo json_encode(array('status'=>0,'msg'=>'该分组已经存在~'));
    }else{
      if($db->data($data)->add()){//分组添加成功
        echo json_encode(array('status'=>1,'msg'=>'添加成功~','lastId'=>$db->getLastInsID()));//返回插入后的ID
      }else{//写入数据库失败
        echo json_encode(array('status'=>0,'msg'=>'添加失败,请重试'));
      }
    }
  }

  //异步添加关注,来自搜索页面弹出框
  Public function addFollow(){
    if(!IS_AJAX) E('页面不存在~',404);
    $data = array(
        'follow'=>I('follow','','intval'),
        'fans'=>session('uid'),
        'gid'=>I('gid','','intval')
      );
    if(M('follow')->data($data)->add()){
      $db = M('userinfo');
      $db->where(array('uid'=>$data['follow']))->setInc('fans');//把被跟随者的粉丝数量加一 有点绕
      $db->where(array('uid'=>$data['fans']))->setInc('follow');
      echo json_encode(array('status'=>1,'msg'=>'关注成功'));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙~请稍后再试'));
    }
  }

  //异步取消关注
  Public function unFollow(){
    if(!IS_AJAX) E('页面不存在~',404);
    $followid = I('follow','','intval');
    $where = array('follow'=>$followid,'fans'=>session('uid'));
    if(M('follow')->where($where)->delete()){
      $db = M('userinfo');
      $db->where(array('uid'=>$followid))->setDec('fans');//把被跟随者的粉丝数量减一 有点绕
      $db->where(array('uid'=>session('uid')))->setDec('follow');
      echo json_encode(array('status'=>1,'msg'=>'取消关注成功~'));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙~请稍后再试'));
    }
  }

  //头像上传图片处理
  Public function uploadFace(){
    if(!IS_POST) E('页面不存在~',404);
      echo json_encode($this->_upload('Face',200,200));
  }

  //微博图片上传
  Public function uploadPic(){
    if(!IS_POST) E('页面不存在~',404);
    $pathArr  = $this->_upload('WBPic',800,800);
    $pathmd   = $this->_thumbnail($pathArr['facePath'],380,380,'md_');//生存缩略图,返回的是地址
    $pathmini = $this->_thumbnail($pathArr['facePath'],120,120,'mini_');//生存缩略图,返回的是地址
    $pathArr['pathmd']   = $pathmd;//把中图和小图压进数组里面
    $pathArr['pathmini'] = $pathmini;
    echo json_encode($pathArr);
  }

  /**
   * 图片上传处理类  19课
   * @param  [String] $path   [保存文件夹名]
   * @param  [String] $width  [缩略图宽度,多个用 , 分割]
   * @param  [String] $height [缩略图高度 同上要与上对其]
   * @param  [String] $name   [图片前缀默认为空,会替换原图片]
   * @return [type]         [图片上传信息]
   */
  private function _upload($path,$width,$height){
    $config = array(
      'maxSize'  => C('UPLOAD_MAX_SIZE'),//图片最大上传大小
      'rootPath' => C('UPLOAD_PATH'),   //图片保存路径
      'savePath' => $path.'/',          //文件保存子目录
      'saveName' => date('Ymd_His').'_'.mt_rand(1,1000), //文件保存规则 这里用的年月日
      'replace'  => true,                //存在同名文件覆盖
      'exts'     => C('UPLOAD_EXTS'), //允许上传的文件后缀
      'autoSub'  => true,
      'subName'  => array('date','Ymd'),  //使用子目录保存文件
    );
    $upload = new \Think\Upload($config);                 // 实例化上传类
    $info = $upload->upload();                                    //执行上传
    foreach($info as $file){//获取上传文件的信息
        $file_path = C('UPLOAD_PATH').$file['savepath'].$file['savename'];
        $file_mini=C('UPLOAD_PATH').$file['savepath'].$file['savename'];  
      }
      $image = new \Think\Image();
      $image->open($file_path);
      if($image->thumb($width,$height,\Think\Image::IMAGE_THUMB_CENTER)->save($file_mini)){//设置大小180  //这里采用的是 缩放填充就是3项
        return array('status'=>1,'facePath'=>substr($file_mini,1));
      }else{
        return array('status'=>0,'msg'=>'服务器正忙,请重新尝试');
      }
  }

  /**
   * 生成缩略图
   * @param  [String] $path   [图像路径]
   * @param  [Int] $width     [缩略图宽度]
   * @param  [Int] $height    [缩略图高度]
   * @param  [String] $name   [缩略图前缀]
   * @return [String]         [文件保存路径]
   */
  private function _thumbnail($path,$width,$height,$name){
    $path    = '.'.$path;
    $i       = strrpos($path,'/')+1;//计算出最后一次出现/的位置
    $newpath = str_insert($path,$i,$name);//在common里面定义的函数,用来在指定位置插入字符串
    $image = new \Think\Image();
    $image->open($path);
    if($image->thumb($width,$height,\Think\Image::IMAGE_THUMB_CENTER)->save($newpath)){//设置大小180  //这里采用的是 缩放填充就是3项
        return substr($newpath,1);
      }else{
        return false;
      }
  }











}
 ?>