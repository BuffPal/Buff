<?php 
/**
 * 模板配置
 */
define('TPL_DIR',ROOT_PATH.'/templates/');             //模板文件目录
define('TPL_C_DIR',ROOT_PATH.'/templates_c/');         //编译文件目录
define('CACHE',ROOT_PATH.'/cache/');                   //缓存文件目录
/**
 * 数据库配置文件
 */
define('DB_HOST' , 'localhost' );                      //主机IP
define('DB_USER' , 'root' );                           //账号
define('DB_PASS' , '' );                               //密码
define('DB_NAME' , 'cms' );                            //选择的数据库
/**
 * 系统配置文件
 */
define('PAGE_SIZE', 10);                               // 每页多少条
define('GPC',get_magic_quotes_gpc());                  //是否开启mysql自动转义功能
define('PREV_URL', $_SERVER["HTTP_REFERER"]);          //获取上一页的路径  (主要用于 分页类 返回修改或删除时的用户体验)
define('NAV_SIZE', 6);                                 //主导航显示条数       貌似现在只能6条
 ?>