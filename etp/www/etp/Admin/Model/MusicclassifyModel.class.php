<?php
/**
 * 后台音乐栏目添加自动验证模型
 */
  namespace Admin\Model;
  use Think\Model;
Class MusicclassifyModel extends Model{

  //自动验证定义
  Protected $_validate = array(
    //是否选择栏目验证
    array('fid','checkEmpty','请选择您添加的父级栏目~',0,'function'),
    array('fid','require','必须选择父级栏目~'),
    //判断栏目名
    array('name','require','必须输入栏目名称~'),
    array('name','','请不要使用重复的栏目名',0,'unique'),
    array('name','1,20','请保证栏目名在20为之内',0,'length'),
    array('name','checkSpecial','栏目名不能存在特殊字符',0,'callback'),
    //判断是否上传了视频封面图
    array('faceurl','require','请上传本栏目的封面图')
    );

  //判断是否有特殊字符
  Public function checkSpecial($data){
    $regex = '/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\ |\　/';
    if(preg_match($regex,$data)){
      return false;
    }else{
      return true;
    }
  }




}