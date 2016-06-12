<?php
//开启SESSION
session_start();
//设置utf-8编码
header('Content-Type:text/html;charset=utf-8');
//网站根目录
define('ROOT_PATH',dirname(__FILE__));
//引入配置信息
require ROOT_PATH.'/config/profile.inc.php';
function __autoload($_className){
  if (substr($_className, -6) == 'Action') {
    require ROOT_PATH.'/action/'.$_className.'.class.php';
  } else if (substr($_className, -5) == 'Model') {
    require ROOT_PATH.'/model/'.$_className.'.class.php';
  } else {
    require ROOT_PATH.'/includes/'.$_className.'.class.php';
  }
}
//实例化模板类
$_tpl = new Template();
//初始化文件 包括缓存配置
require 'common.inc.php';
?>