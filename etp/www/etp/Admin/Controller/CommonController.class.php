<?php
/**
 * 后台自动运行方法
 */
  namespace Admin\Controller;
  use Think\Controller;
Class CommonController extends Controller{

  //自动运行方法
  Public function _initialize(){
    /*是否登录*/
    if(!empty(session('mid'))){

    }else{
      redirect(U('Login/index'));
    }

  }

  //用户退出方法logout
  Public function logout(){
    session_encode();//删除
    session_destroy();//卸载SESSION
    $this->success('安全退出成功,正在返回登录页面',U('Login/index'),3);
  }

  //视频封面海报Uploadify处理
  Public function uploadVideoPoster(){
    if(!IS_POST) E('页面不存在~',404);
    //调用图片处理函数
    $pathArr  = $this->_upload('videoPoster',200,300);
    //生成缩略图
    $pathmd = $this->_thumbnail($pathArr['facePath'],100,150,'md_');//生存缩略图,返回的是地址
    //判断是添加的还是保存的,这里就写一起了.如果是更新的就把原图片删了
    if(!empty(I('id','','intval'))){
      $old_path = M('videoclassify')->where(array('id'=>I('id','','intval')))->field(array('faceurl','faceurl100x150'))->find();
      @unlink('.'.$old_path['faceurl']);
      @unlink('.'.$old_path['faceurl100x150']);
    }
    $pathArr['pathmd'] = $pathmd;
    echo json_encode($pathArr);
  }

  /**
   *上传音乐分类封面图
   */
  Public function uploadMusicPoster(){
    if(!IS_POST) E('页面不存在~',404);
    //调用图片处理函数
    $pathArr  = $this->_upload('musicPoster',40,40);
    //判断是添加的还是保存的,这里就写一起了.如果是更新的就把原图片删了
    if(!empty(I('id','','intval'))){
      $old_path = M('musicclassify')->where(array('id'=>I('id','','intval')))->field(array('faceurl'))->find();
      @unlink('.'.$old_path['faceurl']);
    }
    echo json_encode($pathArr);
  }

  /**
   * 音乐背景图片处理
   */
  Public function uploadMusicBg(){
    if(!IS_POST) E('页面不存在~',404);
    //调用图片处理函数
    $pathArr  = $this->_upload('musicBg',200,204);
    //判断是添加的还是保存的,这里就写一起了.如果是更新的就把原图片删了
    if(!empty(I('id','','intval'))){
      $old_path = M('music')->where(array('id'=>I('id','','intval')))->field(array('musicbgurl'))->find();
      @unlink('.'.$old_path['musicbgurl']);
    }
    echo json_encode($pathArr);
  }

  /**
   * 音乐上传.mp3 处理
   */
  Public function uploadMusic(){
    if(!IS_POST) E('页面不存在~',404);
    $pathArr = $this->_uploadMusic('music');//调用上传类,这是它的保存位置Uploadiy/music
    if($pathArr){

      //修改音乐的话 删除原文件
      if(!empty(I('id','','intval'))){
        $pathArr['Filedata']['getsize'] = getSize($pathArr['Filedata']['size']);
        $old_path = M('music')->where(array('id'=>I('id','','intval')))->field(array('musicurl'))->find();
        @unlink('.'.$old_path['musicurl']);
      }
      // 返回来的数据为
      //{"status":1,"msg":{"Filedata":{"name":"\u6447\u7bee\u66f2\uff08\u8212\u4f2f\u7279\u7248\uff09.mp3","type":"audio\/mpeg","size":1261518,"key":"Filedata","ext":"mp3","md5":"00caea1fdc0026cc50d46d3dba464fdc","sha1":"c7fb96b1576ace10ab43981fa8692c89b79c512e","savename":"20160513_233131_533.mp3","savepath":"music\/20160513\/"}}}
      echo json_encode(array('status'=>1,'msg'=>substr(C('UPLOAD_PATH').$pathArr['Filedata']['savepath'].$pathArr['Filedata']['savename'],1),'size'=>$pathArr['Filedata']['size'],'getsize'=>$pathArr['Filedata']['getsize']));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试'));
    }
  }


  /**
   * 图片上传处理类  
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


  /**
   * 视频上传处理
   */
  Public function uploadVideo(){
    if(!IS_POST) E('页面不存在~',404);
    $pathArr = $this->_uploadVideo('video');//调用上传类,这是它的保存位置Uploadiy/video
    //{"status":1,"msg":{"Filedata":{"name":"123.mp4","type":"video\/mp4","size":826711362,"key":"Filedata","ext":"mp4","md5":"156de8ce8a595657a3c4d7ce974a64c5","sha1":"3f6e7f8da6d060ee623c32309562e7d8a20dfa1d","savename":"20160510_203839_360.mp4","savepath":"video\/20160510\/"}}}这是前端接受到的数据,
    //这里可以得到视频路径为 substr(C('UPLOAD_PATH').$pathArr['Filedata']['savepath'].$pathArr['Filedata']['savename'],1)
    if($pathArr){

      if(!empty(I('id','','intval'))){
        $pathArr['Filedata']['getsize'] = getSize($pathArr['Filedata']['size']);
        $old_path = M('video')->where(array('id'=>I('id','','intval')))->field(array('videourl'))->find();
        @unlink('.'.$old_path['videourl']);
      }
      echo json_encode(array('status'=>1,'msg'=>substr(C('UPLOAD_PATH').$pathArr['Filedata']['savepath'].$pathArr['Filedata']['savename'],1),'size'=>$pathArr['Filedata']['size'],'getsize'=>$pathArr['Filedata']['getsize']));
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请稍后重试~'));
    }
  }

  /**
   * 视屏上传封面图处理
   */
  Public function uploadVideoPic(){
    if(!IS_POST) E('页面不存在~',404);
    //调用图片处理函数
    $pathArr  = $this->_upload('videoPic',1280,720);
    //生成缩略图
    $pathmd = $this->_thumbnail($pathArr['facePath'],176,99,'md_');//生存缩略图,返回的是地址
    //判断是添加的还是保存的,这里就写一起了.如果是更新的就把原图片删了
    if(!empty(I('id','','intval'))){
      $old_path = M('video')->where(array('id'=>I('id','','intval')))->field(array('videopicurl','videopicurl176'))->find();
      @unlink('.'.$old_path['videopicurl']);
      @unlink('.'.$old_path['videopicurl176']);
    }
    $pathArr['pathmd'] = $pathmd;
    echo json_encode($pathArr);    
  }

  /**
   * 视频上传处理类  
   * @param  [String] $path   [保存文件夹名]
   * @return [type]         [图片上传信息]
   */
  private function _uploadVideo($path){
    $config = array(
      'maxSize'  => C('UPLOAD_MAX_SIZE_VIDEO'),//视频最大上传大小
      'rootPath' => C('UPLOAD_PATH'),   //图片保存路径
      'savePath' => $path.'/',          //文件保存子目录
      'saveName' => date('Ymd_His').'_'.mt_rand(1,1000), //文件保存规则 这里用的年月日
      'replace'  => true,                //存在同名文件覆盖
      'exts'     => C('UPLOAD_EXTS_VIDEO'), //允许上传的文件后缀
      'autoSub'  => true,
      'subName'  => array('date','Ymd'),  //使用子目录保存文件
    );
    $upload = new \Think\Upload($config);                 // 实例化上传类
    $info = $upload->upload();   //执行上传
    //返回info                                 
    if($info){
      return $info;
    }else{
      return false;
    }
  }


  /**
   * 音乐上传处理类  
   * @param  [String] $path   [保存文件夹名]
   * @return [type]         [图片上传信息]
   */
  private function _uploadMusic($path){
    $config = array(
      'maxSize'  => C('UPLOAD_MAX_SIZE_MUSIC'),//视频最大上传大小
      'rootPath' => C('UPLOAD_PATH'),   //图片保存路径
      'savePath' => $path.'/',          //文件保存子目录
      'saveName' => date('Ymd_His').'_'.mt_rand(1,1000), //文件保存规则 这里用的年月日
      'replace'  => true,                //存在同名文件覆盖
      'exts'     => C('UPLOAD_EXTS_MUSIC'), //允许上传的文件后缀
      'autoSub'  => true,
      'subName'  => array('date','Ymd'),  //使用子目录保存文件
    );
    $upload = new \Think\Upload($config);                 // 实例化上传类
    $info = $upload->upload();   //执行上传
    //返回info                                 
    if($info){
      return $info;
    }else{
      return false;
    }
  }


}