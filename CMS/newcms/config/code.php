<?php 
require substr(dirname(__FILE__),0,-7).'/init.inc.php';
$_vc = new ValidateCode();
$_vc->doimg();
$_SESSION['code'] = $_vc->getCode();           //生成 SESSION 用来验证验证码是否正确
 ?>
