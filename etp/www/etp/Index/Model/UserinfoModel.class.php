<?php  
/**
 * 用户个人信息模型
 */
namespace Index\Model;
use Think\Model;
Class UserinfoModel extends Model{

  //定义自动验证方法
  Protected $_validate = array(
    //验证用户名
    array('username','require','用户昵称不能为空'),
    array('username','2,10','用户昵称应在2~10位',0,'length'),
    array('username','checkUsername','用户昵称被占用啦~',0,'callback'),
    array('username','checkSpecial','用户昵称不能存在特殊字符!!!',0,'callback'),
    //真实名称验证
    array('truename','2,20','真实名称因在2~20位之间~',2,'length'),
    array('truename','checkSpecial','真实名称不能存在特殊字符!!!',2,'callback'),
    //生日验证  这里有精髓,貌似数组存在值他也认为是空,那就让他强行验证,到下面咱自己验证
    array('day','checkDay','请把您的生日信息选择完整~',0,'callback'),
    //一句话验证
    array('intro','1,70','一句话介绍自己请在70位之内',2,'length'),
    //blogURL 地址验证
    array('blog','checkUrl','请输入正确的博客地址~',2,'callback'),
    //MSN验证
    array('msn','checkUrl','请输入正确的MSN地址~',2,'callback'),
    //QQ
    array('qq','number','请输入正确的QQ号',2),
    array('qq','2,11','请输入正确的QQ号',2,'length')
  );

  //用户名是否存在验证 ????这里是函数内部还不让用 Private
  Public function checkUsername($data){
    $where = array('username'=>$data,'uid'=>array('NEQ',session('uid')));
    if(M('userinfo')->where($where)->setField('id')){
      return false;
    }else{
      return true;
    }
  }

  //判断是否有特殊字符
  Public function checkSpecial($data){
    $regex = '/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\ |\　/';
    if(preg_match($regex,$data)){
      return false;
    }else{
      return true;
    }
  }

  //判断生日是否选择了三项
  Public function checkDay($data){
    //数组存在验证,不存在直接通过
    if($data[0]!=0){
      //这里不选的话默认是0
      if($data[2]==0){
        return false;
      }else{
        return true;
      }
    }else{
      return true;
    }
  }

  //URL验证这THinkphp 不加http://不行 咱写一个不用的,到后期自动加上
  Public function checkUrl($data){
    $regex = '/(?:http:\/\/)?([\w.]+[\w\/]*\.[\w.]+[\w\/]*\??[\w=\&\+\%]*)/is';
    if(preg_match($regex,$data)){
      return true;
    }else{
      return false;
    }
  }

}
