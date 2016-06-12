<?php
/**
 * 后台音乐栏目添加自动验证模型
 */
  namespace Admin\Model;
  use Think\Model;
Class MusicModel extends Model{

  //自动验证定义
  Protected $_validate = array(
    //是否选择栏目验证
    array('cid','checkEmpty','请选择您添加的父级栏目~',0,'function'),
    array('cid','require','必须选择父级栏目~'),
    //判断音乐名
    array('musicname','require','必须输入音乐名~'),
    array('musicname','1,20','请保证音乐名在20为之内',0,'length'),
    //判断音乐名
    array('author','require','必须输入作者名~'),
    array('author','1,20','请保证作者名在20为之内',0,'length'),
    array('author','checkSpecial','作者名不能存在特殊字符',0,'callback'),
    //判断是否上传了音乐背景
    array('musicbgurl','require','请上传本栏目的封面图'),
    //判断是否上传了音乐
    array('musicurl','require','请上传本栏目的封面图')
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