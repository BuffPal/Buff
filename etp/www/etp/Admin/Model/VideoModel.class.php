<?php
/**
 * 后台视频上传模型
 */
  namespace Admin\Model;
  use Think\Model;
Class VideoModel extends Model{

  //自动验证定义
  Protected $_validate = array(
    //是否选择栏目验证
    array('cid','checkEmpty','请选择您要上传的栏目~',0,'function'),
    //判断视频名称是否匹配
    array('videoname','require','必须输入视频名称~'),
    array('videoname','1,20','请保证视频名在20为之内',0,'length'),
    //判断是否上传了视频封面图
    array('videopicurl','require','请上传本视频的封面图'),
    //判断视频是否上传了
    array('videourl','require','请上传您的视频')

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