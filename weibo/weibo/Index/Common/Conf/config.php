<?php
return array(
  'DEFAULT_CHARSET'  => 'utf-8', // 默认输出编码
  'DEFAULT_TIMEZONE' => 'PRC', // 默认时区
  /**
   * 数据库配置 PDO
   */
  'DB_TYPE'         => 'mysql',
  'DB_USER'         => 'root',
  'DB_PWD'          =>  '',
  'DB_PREFIX'       =>  'wb_',
  'DB_DSN'          => 'mysql:host=localhost;dbname=weibo;charset=UTF8',  //最新 POD 配置方式
  
  'SHOW_PAGE_TRACE' => false,          //开启调试
  'DB_FIELDS_CACHE' => false,         //关闭字段缓存(读取数据库的)
  'DEFAULT_THEME'   => 'default' ,   //默认模板主题
  'URL_HTML_SUFFIX' => '', // URL伪静态后缀设置

  //用于异位或加密的key
  'ENCTYPTION_KEY'  => 'liuhao',
  //自动登录保存时间
  'AUTO_LOGIN_TIME' => time()+3600*24*7,    //一个星期
  //图片上传处理
  'UPLOAD_MAX_SIZE' => 3145728,      //最大 2M
  'UPLOAD_PATH'     => './Uploads/', //文件上传保存路径//这个是按 项目文件路劲来算的
  'UPLOAD_EXTS'     =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
  'PREV_URL'        => $_SERVER["HTTP_REFERER"], //获取上一页记录
  'INDEX_SERCH_PAGE_SIZE' => 10,  //前台搜索分页显示条数
  'INDEX_WEIBO_PAGE_SIZE' => 8,   //前台微博分页显示条数
  //URL 路由配置
  'URL_ROUTER_ON'=>true,
  'URL_ROUTE_RULES'=>array(       //定义路由规则
      ':id\d'=>'Index/index',
      'discuss/:wid\d'=>'Discuss/index',//详细评论
      'fans/:uid\d'=>array('FollowList/index','type=1'),//用于点击粉丝或者关注时的判断
      'follow/:uid\d'=>array('FollowList/index','type=0'),
    ),

  //文件缓存配置
  'DATA_CACHE_SUBDIR' =>true,  //开启以哈希形式生产缓存目录
  'DATA_PATH_LEVEL'   =>2,         //目录层次
  'CACHE_MAX_TIME'    =>3600,     //缓存时间,自己定义的

  'TMPL_EXCEPTION_FILE'=>'./App/Tpl/Public/error.html', // 定义公共错误模板

);