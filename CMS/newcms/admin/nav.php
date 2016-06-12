<?php 
require substr(dirname(__FILE__),0,-6).'/init.inc.php';//这里的用意就是因为admin目录下没有init.inc.php文件 ROOT_PATH 在admin下面用就是指向admin
Validate::checkSession();//判断有没有session,用来防判断是否登录  为啥要放在这里? 203课 15分钟
global $_tpl;
$nav = new NavAction($_tpl);
$nav->_action();          //执行业务控制器
$_tpl->display('nav.tpl');
 ?>