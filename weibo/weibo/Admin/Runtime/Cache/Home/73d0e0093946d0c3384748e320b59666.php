<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="/weibo/Public/css/admin.css">
  <script type="text/javascript" src="/weibo/Public/js/j.js"></script>
  <script type="text/javascript">
    var locksUrl = "<?php echo U('locks');?>";
  </script>
  <script type="text/javascript" src="/weibo/Public/js/admin.js"></script>
  <title></title>
</head>
<body>
  <div id="main">
    <table>
      <tr><th>ID</th><th>用户昵称</th><th>头像</th><th>关注信息</th><th>注册时间</th><th>账号状态</th><th>操作</th></tr>
    <?php if($resultAll): if(is_array($resultAll)): foreach($resultAll as $key=>$vo): ?><tr>
            <td><?php echo ($vo["uid"]); ?></td>
            <td><?php echo ($vo["username"]); ?></td>
            <td><img src="<?php if($vo['face']): ?>/weibo<?php echo ($vo["face"]); else: ?>/weibo/Public/images/none.png<?php endif; ?>" width="30" height="30"></td>
            <td>关注:<span><?php echo ($vo["follow"]); ?></span> 粉丝:<span><?php echo ($vo["fans"]); ?></span> 微博:<span><?php echo ($vo["weibo"]); ?></span></td>
            <td><?php echo ($vo["registime"]); ?></td>
            <td class="locksTd"><a href="" class="locks" status="<?php echo ($vo["locks"]); ?>" uid="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["locks"]); ?></a></td>
            <td>没有操作</td>
          </tr><?php endforeach; endif; endif; ?>
    </table>
    <div class="pages"><?php echo ($page); ?></div>
  </div>
</body>
</html>