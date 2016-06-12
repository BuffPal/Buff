<?php 
require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global $_tpl;
Validate::checkSession();//判断有没有session,用来防判断是否登录
$_tpl->display('main.tpl');


 ?>