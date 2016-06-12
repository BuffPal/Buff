<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../style/admin.css">
  <script type="text/javascript" src="../js/tool.js"></script>
  <script type="text/javascript" src="../js/admin_top_nav.js"></script>
</head>
<body id="top">
  <h1>LOGO</h1>
  <ul>
    <li><a id="nav1" target="sidebar" href="../templates/sidebar.html" class="selected" onclick="admin_top_nav(1)">首页</a></li>
    <li><a id="nav2" target="sidebar" href="../templates/sidebarn.html" onclick="admin_top_nav(2)">内容</a></li>
    <li><a id="nav3" target="sidebar" href="#" onclick="admin_top_nav(3)">会员</a></li>
    <li><a id="nav4" target="sidebar" href="#" onclick="admin_top_nav(4)">系统</a></li>
  </ul>

  <p>
    您好,
    <strong>{$admin_user}</strong>
    [ {$level_name}]
    [ <a href="../" target="_blak">去首页</a> ]
    [ <a href="admin_login.php?action=logout" target="_parent">退出</a> ]

  </p>
</body>
</html>