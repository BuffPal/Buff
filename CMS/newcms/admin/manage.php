<?php 
require substr(dirname(__FILE__),0,-6).'/init.inc.php';//这里的用意就是因为admin目录下没有init.inc.php文件 ROOT_PATH 在admin下面用就是指向admin
Validate::checkSession(); //这是一个session判断.login是前台判断了就登录不了了,就放在这里 ,下面的都判断
global $_tpl;
$manage = new ManageAction($_tpl);
$manage->_action();
$_tpl->display('manage.tpl');
 ?>