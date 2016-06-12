<?php 
/**
 * 分离前台和后台的缓存文件       前台
 */
//是否开启缓冲区
define('IS_CACHE',false);
//判断是否开启缓冲区
IS_CACHE ? ob_start() : null;
/**
 * 模板句柄
 */
global $_tpl;
$_nav = new NavAction($_tpl);
$_nav->showFront()               //列出主导航
 ?>