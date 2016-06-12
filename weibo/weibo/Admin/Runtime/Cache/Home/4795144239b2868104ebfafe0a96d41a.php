<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/css/admin.css">
  <script type="text/javascript" src="/weibo/Public/js/tool.js"></script>
  <script type="text/javascript" src="/weibo/Public/js/admin_top_nav.js"></script>
</head>
<body id="top">
  <h1>LOGO</h1>
  <ul>
    <li><a id="nav1" target="sidebar" href="<?php echo U('sidebar');?>" class="selected" onclick="admin_top_nav(1)">首页</a></li>
    <li><a id="nav2" target="sidebar" href="<?php echo U('sidebarn');?>" onclick="admin_top_nav(2)">内容</a></li>
    <li><a id="nav3" target="sidebar" href="<?php echo U('sidebaru');?>" onclick="admin_top_nav(3)">会员</a></li>
    <li><a id="nav4" target="sidebar" href="<?php echo U('sidebars');?>" onclick="admin_top_nav(4)">系统</a></li>
  </ul>

  <p>
    您好,
    <strong>炒鸡管理员</strong>
    [ <?php echo ($username); ?>]
    [ <a href="/weibo" target="_blak">去首页</a> ]
    [ <a href="<?php echo U('Common/logOut');?>" target="_parent">退出</a> ]

  </p>
</body>
</html>