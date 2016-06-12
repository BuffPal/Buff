<?php
/**
 * 前台公用控制器
 */
namespace Index\Controller;
use Think\Controller;
Class CommonController extends Controller{

    Public function _initialize(){//自动运行函数 用于前台判断用户是否登录
        //处理自动登陆 Cookie
        if(isset($_COOKIE['auto']) && !isset($_SESSION['uid'])){//cookie 存在 并且用户在非登录状态(SESSION没有uid)
          $value = explode('|',encryption($_COOKIE['auto'],1));//拆分客户端cookie 函数在Common里面定义的
          $ip    = get_client_ip();//获取客户端IP地址
          if($ip == $value[1]){//判断当前客户端IP是否等于上次登录保存的IP
            $account = $value[0];
            $where = array('account'=>$account);
            $user = M('user')->where($where)->field(array('id','locks'))->find();//查找当前 cookie 里面的用户名保存 到 SESSION里面
            if($user && !$user['locks']){//判断是否是伪造的account //如果查询不出来表示当前数据库没有该用户
              session('uid',$user['id']);
            }else{
              $this->error('您的账号已被锁定,请联系管理员');
            }
          }
        }
    }


 //退出登录处理
  public function logout(){
    //卸载SESSION
    session_unset();
    session_destroy();

    //删除cookie
    setcookie('auto','',time()-1,'/');
    header('Content-Type:text/html;Charset=UTF-8');
    redirect(U('Login/login'));
  }




    /**
     * 前台 music 模态框 mid取数据
     */
    Public function musicAjax(){
        if(!IS_AJAX) E('页面不存在~');
        $mid = I('mid','','intval');
        //数据库取数据
        $data = M('music')->where(array('id'=>$mid))->field(array('id','musicname','author','musicurl','musicbgurl','cid'))->find();
        //获取父级分类名
        $classify = M('musicclassify')->where(array('id'=>$data['cid']))->getField('name');
        //压入$data
        $data['classifyname'] = $classify;
        if($data){
          echo json_encode(array('status'=>1,'msg'=>$data));
        }else{
          echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请重新尝试'));
        }
    }


    /**
    * 前台video 模态框 vid取数据
    */
    Public function videoAjax(){
        if(!IS_AJAX) E('页面不存在~');
        $vid = I('vid','','intval');
        //获取数据库信息
        if($data = M('video')->where(array('id'=>$vid))->field(array('id','videourl','videopicurl','videoname'))->find()){
          echo json_encode(array('status'=>1,'msg'=>$data));
          //数据库给它的播放数加一
          M('video')->where(array('id'=>$vid))->setInc('playcount');
        }else{
          echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请重新尝试~'));
        }
        
    }



  //头像上传图片处理
  Public function uploadFace(){
    if(!IS_AJAX) E('页面不存在~',404);
    $data = I('urlPic');
    //去掉开头的标识符,这个必须要去掉应为它没啥用
    $base64_body = substr(strstr($data,','),1);
    //解码
    $data= base64_decode($base64_body);
    /**
     * 这里定义的图片保存路径  Public 这里可以替换,这里就不麻烦了
     */
    $dir = C('userpic_DIR');
    if (!is_dir($dir.date('Y-m-d').'/')) mkdir($dir.date('Y-m-d').'/'); // 如果不存在则创建 目录
    $path = $dir.date('Y-m-d').'/'.date('H_i_s').'_'.rand().'.jpeg';//整体的

    //保存图片
    if(!empty(file_put_contents($path,$data))){
      //这里是已经保存成功,更新数据库
      $where = array('uid'=>session('uid'));
      if($oldPath = M('userinfo')->where($where)->field(array('userpic'))->find()){
          //存在时删除原图像后在更新
         @unlink($oldPath['userpic']);
         if(M('userinfo')->where(array('uid'=>session('uid')))->save(array('userpic'=>$path))){
            echo json_encode(array('status'=>1,'msg'=>$path));
         }else{
            echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请重新尝试3'));
         }
      }else{
         if(M('userinfo')->where(array('uid'=>session('uid')))->save(array('userpic'=>$path))){
            echo json_encode(array('status'=>1,'msg'=>$path));
         }else{
            echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请重新尝试2'));
         }        
      }
    }else{
      echo json_encode(array('status'=>0,'msg'=>'服务器正忙,请重新尝试1'));
    };

  }




}