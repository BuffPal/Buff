<?php 
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global $_tpl;
Validate::checkSession();//判断有没有session,用来防判断是否登录
//注入后台登陆用户变量
$_tpl->assign('admin_user',$_SESSION['admin']['admin_user']);
$_tpl->assign('level_name',$_SESSION['admin']['level_name']);
$_tpl->display('top.tpl');
 ?>