<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>用户注册</title>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/css/reg.css">
  <script type="text/javascript" src="/weibo/Public/js/j.js"></script>
  <script type="text/javascript">
   var AjaxUrl = "<?php echo U('cacheAjax');?>"
   var AjaxVerify = "<?php echo U('cacheVerify');?>"
   </script>
  <script type="text/javascript" src="/weibo/Public/js/register.js"></script>
</head>
<body>
  <h1>用户注册</h1>
  <form action="<?php echo U('runRegister');?>" method="post">
    <table>
      <tr><td>登录账号:<input type="text" name="account"></td></tr>
      <tr><td>登录密码:<input type="password" name="password"></td></tr>
      <tr><td>确认密码:<input type="password" name="notPassword"></td></tr>
      <tr><td>用户昵称:<input type="text" name="username"></td></tr>
      <tr><td>　验证码:<input type="text" name="verify"></td></tr>
      <tr><td><img src="<?php echo U('verify');?>" class="verify"></td></tr>
      <tr><td><input type="submit" value="注册"></td></tr>
    </table>
  </form>
</body>
</html>