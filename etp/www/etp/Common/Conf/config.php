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
  'DB_PREFIX'       =>  'etp_',
  'DB_DSN'          => 'mysql:host=localhost;dbname=etp;charset=UTF8',  //最新 POD 配置方式
  
  'SHOW_PAGE_TRACE' => false,          //开启调试
  'DB_FIELDS_CACHE' => false,         //关闭字段缓存(读取数据库的)
  'URL_HTML_SUFFIX' => '', // URL伪静态后缀设置
  'MODULE_ALLOW_LIST' => array('Index','Admin'),
  'PREV_UREL' => $_SERVER["HTTP_REFERER"],//上一页地址

  //用于异位或加密的key
  'ENCTYPTION_KEY'  => 'sublime',


  //用户头像上传保存目录 这里建议 刚开始运行的时候改 若运行以后在改的话,将会导致数据库图片路径出错
  'USERPIC_DIR'=>'UserPic/',

);