<?php 
/**
 * 用户设置控制器
 */
namespace Home\Controller;
Class UserSettingController extends CommonController{
  //用户设置
  Public function index(){
    if(isset($_GET['type'])){
      $this->assign('type','face');
    }
    //获取用户数据库字段
    $field = array('username','truename','sex','location','constellation','intro','face');//这里主要是为了节省资源
    $this->userinfo = M('userinfo')->field($field)->where(array('uid'=>$_SESSION['uid']))->find();
    $this->assign('prev_url',C('PREV_URL'));
    $this->display();
  }

  //修改用户基本信息 表单提交处理
  Public function editBasic(){
    if(!IS_POST) E('页面丢失了',404);
    $prev_url = I('prev_url');
    $data = array(
    'username'      => I('username'),
    'truename'      => I('truename'),
    'sex'           => I('sex'),
    'location'      => I('province').','.I('city').','.I('dist'),//这里是把城市联动连接在一起
    'constellation' => I('night'),
    'intro'         => I('intro')
    );
    if(M('userinfo')->where(array('uid'=>session('uid')))->save($data)){
      $this->success('修改成功',$prev_url);
    }else{
      $this->error('修改失败,请重新修改');
    }
  }

  //用户头像修改处理
  Public function editFace(){
    if(!IS_POST) E('页面丢失了',404);
    $prev_url = I('prev_url');
    $db = M('userinfo');
    $where = array('uid'=>session('uid'));
    $data = array('face'=>I('faceSql'));
    $field = array('face');
    $old = $db->where($where)->field($field)->find();//这个要写在上面,在更新成功后 用来删除原来的头像
    if($db->where($where)->save($data)){//更新数据库
        if(!empty($old['face'])){
          @unlink('.'.$old['face']);//用户已经上传过头像了 就删除他
        } 
      $this->success('修改成功',$prev_url);
    }
  }

  //用户密码修改(没有邮箱验证)
  Public function editPwd(){
    if(!IS_POST) E('页面丢失',404);
    $prev_url    = I('prev_url');
    $oldPwd      = I('oldpassword','','md5');
    $notPassword = I('notpassword');
    $db          = M('user');
    $where       = array('id'=>session('uid'));
    $data        = array('password'=>I('newpassword','','md5'));
    $field       = array('password');
    $old = $db->field($field)->where($where)->find();
    if($old['password'] != $oldPwd) $this->error('旧密码有误~');
    if($db->where($where)->save($data)){
      $this->success('修改成功',U('Index/logout'));
    }else{
      $this->error('修改失败,请重新尝试');
    }


  }

}
 ?>