<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <style type="text/css">
  table.one{
    display: block;
    float: left;
  }
  table.two{
    display: block;
    float: left;
    margin-left: 20%;
  }
  
  </style>
</head>
<body>
  <table  class="one">
    <tr><th>个人信息</th><th></th></tr>
    <tr><td>管理员名</td>　　<td>[<?php echo ($username); ?>]</td></tr>
    <tr><td>上次登录时间</td>　　<td>[<?php echo (date('Y-m-d H:i:s',$loginTime)); ?>]</td></tr>
    <tr><td>上次登录ip</td>　　<td>[<?php echo ($loginIp); ?>]</td></tr>
    <tr><td></td>　　<td></td></tr>
    <tr><td>本次登录时间</td>　　<td>[<?php echo ($nowLoginTime); ?>]</td></tr>
    <tr><td>本次登录ip</td>　　<td>[<?php echo get_client_ip();?>]</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><th>用户信息</th><th></th></tr>
    <tr><td>共有注册用户</td><td>　　[<?php echo ($userCount); ?>]个</td></tr>
    <tr><td>当前被锁定用户</td><td>　　[<?php echo ($userLocks); ?>]个</td></tr>
  </table>

  <table class="two" > 
    <tr><th>服务器信息</th><th></th></tr>
    <tr><td>操作系统</td>　　<td>[<?php echo (PHP_OS); ?>]</td></tr>
    <tr><td>PHP版本</td>　　<td>[<?php echo (PHP_VERSION); ?>]</td></tr>
    <tr><td>服务器版本</td>　　<td>[<?php echo ($_SERVER['SERVER_SOFTWARE']); ?>]</td></tr>
    <tr><td>MySQL版本</td>　　<td>[<?php echo mysql_get_server_info();?>]</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><td>　</td>　　<td>　</td></tr>
    <tr><th>微博信息</th><th></th></tr>
    <tr><td>原作微博共</td><td>　　[<?php echo ($wbCount); ?>]条</td></tr>
    <tr><td>转发微博共</td><td>　　[<?php echo ($wbOCount); ?>]条</td></tr>
    <tr><td>微博评论共</td><td>　　[<?php echo ($commentCount); ?>]条</td></tr>
  </table>
</body>
</html>