<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../style/admin.css">
  <script type="text/javascript" src="../js/tool.js"></script>
  <script type="text/javascript" src="../js/manage_updata.js"></script>
</head>
<body id="main">
  <div class="map">
    <a href="admin.php" target="admin.php">管理首页</a>&gt;&gt;<a href="manage.php?action=show">管理员管理</a>&gt;&gt;<strong id="strong"><?php echo $this->_vars['title'];?></strong>
  </div>
  <ol>
    <li><a href="manage.php?action=show" class="selected">管理员列表<i class="icon-compass"></i></a></li>
    <li><a href="manage.php?action=add">添加管理员<i class="icon-compass"></i></a></li>
    <?php if ($this->_vars['update']) {?>
    <li><a href="manage.php?action=update">修改管理员<i class="icon-compass"></i></a></li>
    <?php } ?>
  </ol>
  <?php if ($this->_vars['show']) {?>
  <div id="tableBox">
    <table border="0" cellspacing="0">
      <tr><th style="width: 10%;">编号/序号</th><th style="width: 10%;">用户名</th><th style="width: 10%;">等级</th><th style="width: 10%;">登录次数</th><th style="width: 10%;">最后一次登录IP</th><th style="width: 10%;">最后一次登录时间</th><th style="width: 10%;">操作</th></tr>
      <?php if ($this->_vars['ALLManage']) {?>
      <?php foreach ($this->_vars['ALLManage'] as $key=>$value) { ?>
      <tr>                                 <!-- 这是是输出文本到浏览器 $num这个变量的公式 在 Action 里面 205课 20分钟 -->
        <td><script type="text/javascript">document.write(<?php echo $key+1?>+<?php echo $this->_vars['num'];?>)</script></td>
        <td><?php echo $value->admin_user?></td>
        <td><?php echo $value->level_name?></td>
        <td><?php echo $value->login_count?></td>
        <td><?php echo $value->last_ip?></td>
        <td><?php echo $value->last_time?></td>
        <td><a href="manage.php?action=update&id=<?php echo $value->id?>"> [ 修改 ] </a>|<a href="manage.php?action=delete&id=<?php echo $value->id?>" onclick="return confirm('确认删除?') ? true : false"> [ 删除 ] </a></td>
        </tr>
      <?php } ?>
        <?php } else { ?>
        <tr><td colspan="7"><i class="icon-quill"></i> 没 有 任 何 数  据 ! </td></tr>
      <?php } ?>
    </table>
  </div>
  <div id="page">
    <?php echo $this->_vars['page'];?>
  </div>
  <?php } ?>

  <?php if ($this->_vars['add']) {?>
    <div class="addTable">
      <form action="" method="post" name="add">
        <table>
        <tr><td style="text-align: right;">用户名:<input type="text" name="admin_user" class="text" ></td><td align="left"><i>大于2,小于20</i></td></tr>
       <tr><td style="text-align: right;">密&nbsp;码:<input type="password" name="admin_pass" class="text"></td><td align="left"><i>大于6位</i></td></tr>
       <tr><td style="text-align: right;">确认密码:<input type="password" name="admin_notpass" class="text"></td><td align="left"><i>必须与上面相同</i></td></tr>
        <tr><td style="text-align: right;"> 等 级 : <select name="level">
                          <?php foreach ($this->_vars['levelSelect'] as $key=>$value) { ?>
                          <option value="<?php echo $value->id?>"><?php echo $value->level_name?></option>
                          <?php } ?>
                          </select>
        </td></tr>
        <tr><td><a href="<?php echo $this->_vars['prev_url'];?>" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addSubmit" class="submit" value="新增管理员" onclick=" return checkAddForm();"></td><td></td></tr>
        </form>
      </table>
    </div>
  <?php } ?>
  
  <?php if ($this->_vars['update']) {?>
     <div class="addTable">
      <form action="" method="post" name="update">
        <input type="hidden" value="<?php echo $this->_vars['id'];?>" name="id">
        <input type="hidden" value="<?php echo $this->_vars['level'];?>" id="upData_level">
        <input type="hidden" value="<?php echo $this->_vars['prev_url'];?>" name="prev_url">
        <input type="hidden" value="<?php echo $this->_vars['admin_pass'];?>" name="passa">
        <table>
        <tr><td style="text-align: right;">用户名:<input type="text" name="admin_user" class="text" value="<?php echo $this->_vars['admin_user'];?>" readonly="readonly"></td><td align="left"><i>正确</i></td></tr>
       <tr><td style="text-align: right;">密&nbsp;码:<input type="password" name="admin_pass" class="text" ></td><td align="left"><i>留空为不修改</i></td></tr>
        <tr><td style="text-align: right;"> 等 级 : <select name="level">
                          <?php foreach ($this->_vars['levelSelect'] as $key=>$value) { ?>
                          <option value="<?php echo $value->id?>"><?php echo $value->level_name?></option>
                          <?php } ?>
                          </select>
        </td></tr>
        <tr><td><a href="<?php echo $this->_vars['prev_url'];?>" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="submit" class="submit" value="修改管理员" onclick="return checkUpdateForm();"></td><td></td></tr>
        </form>
      </table>
    </div>
  <?php } ?>



</body>
</html>