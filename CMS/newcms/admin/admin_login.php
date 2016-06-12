<?php 
require substr(dirname(__FILE__),0,-6).'/init.inc.php';//这里的用意就是因为admin目录下没有init.inc.php文件 ROOT_PATH 在admin下面用就是指向admin
global $_tpl;
$_login = new LoginAction($_tpl);
$_login->_action();
if(isset($_SESSION['admin'])) Tool::alertLocation(null,'admin.php'); ///房子已经登陆用户强行进入amdin_login
$_tpl->display('admin_login.tpl');
 ?>