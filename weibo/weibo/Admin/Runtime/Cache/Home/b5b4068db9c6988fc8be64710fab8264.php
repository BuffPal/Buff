<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/css/admin.css">
</head>
<body id="sidebar">
  <dl>
    <dt><a href="#">用户管理</a></dt>
    <dd><a href="<?php echo U('main');?>" target="map">后台首页</a></dd>
    <dd><a href="<?php echo U('User/wbuser');?>" target="map">微博用户</a></dd>
    <dd><a href="" target="map">微博用户检索</a></dd>
    <dd><a href="" target="map">后台管理员</a></dd>
    <dd><a href="" target="map">添加管理员</a></dd>
  </dl>
</body>
</html>