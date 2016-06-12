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
    <a href="admin.php" target="admin.php">管理首页</a>&gt;&gt;<a href="manage.php?action=show">管理员管理</a>&gt;&gt;<strong id="strong">{$title}</strong>
  </div>
  <ol>
    <li><a href="manage.php?action=show" class="selected">管理员列表<i class="icon-compass"></i></a></li>
    <li><a href="manage.php?action=add">添加管理员<i class="icon-compass"></i></a></li>
    {if $update}
    <li><a href="manage.php?action=update">修改管理员<i class="icon-compass"></i></a></li>
    {/if}
  </ol>
  {if $show}
  <div id="tableBox">
    <table border="0" cellspacing="0">
      <tr><th style="width: 10%;">编号/序号</th><th style="width: 10%;">用户名</th><th style="width: 10%;">等级</th><th style="width: 10%;">登录次数</th><th style="width: 10%;">最后一次登录IP</th><th style="width: 10%;">最后一次登录时间</th><th style="width: 10%;">操作</th></tr>
      {if $ALLManage}
      {foreach name='ALLManage' key=key item=value}
      <tr>                                 <!-- 这是是输出文本到浏览器 $num这个变量的公式 在 Action 里面 205课 20分钟 -->
        <td><script type="text/javascript">document.write({@key+1}+{$num})</script></td>
        <td>{@value->admin_user}</td>
        <td>{@value->level_name}</td>
        <td>{@value->login_count}</td>
        <td>{@value->last_ip}</td>
        <td>{@value->last_time}</td>
        <td><a href="manage.php?action=update&id={@value->id}"> [ 修改 ] </a>|<a href="manage.php?action=delete&id={@value->id}" onclick="return confirm('确认删除?') ? true : false"> [ 删除 ] </a></td>
        </tr>
      {/foreach}
        {else}
        <tr><td colspan="7"><i class="icon-quill"></i> 没 有 任 何 数  据 ! </td></tr>
      {/if}
    </table>
  </div>
  <div id="page">
    {$page}
  </div>
  {/if}

  {if $add}
    <div class="addTable">
      <form action="" method="post" name="add">
        <table>
        <tr><td style="text-align: right;">用户名:<input type="text" name="admin_user" class="text" ></td><td align="left"><i>大于2,小于20</i></td></tr>
       <tr><td style="text-align: right;">密&nbsp;码:<input type="password" name="admin_pass" class="text"></td><td align="left"><i>大于6位</i></td></tr>
       <tr><td style="text-align: right;">确认密码:<input type="password" name="admin_notpass" class="text"></td><td align="left"><i>必须与上面相同</i></td></tr>
        <tr><td style="text-align: right;"> 等 级 : <select name="level">
                          {foreach name='levelSelect' key=key item=value}
                          <option value="{@value->id}">{@value->level_name}</option>
                          {/foreach}
                          </select>
        </td></tr>
        <tr><td><a href="{$prev_url}" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addSubmit" class="submit" value="新增管理员" onclick=" return checkAddForm();"></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}
  
  {if $update}
     <div class="addTable">
      <form action="" method="post" name="update">
        <input type="hidden" value="{$id}" name="id">
        <input type="hidden" value="{$level}" id="upData_level">
        <input type="hidden" value="{$prev_url}" name="prev_url">
        <input type="hidden" value="{$admin_pass}" name="passa">
        <table>
        <tr><td style="text-align: right;">用户名:<input type="text" name="admin_user" class="text" value="{$admin_user}" readonly="readonly"></td><td align="left"><i>正确</i></td></tr>
       <tr><td style="text-align: right;">密&nbsp;码:<input type="password" name="admin_pass" class="text" ></td><td align="left"><i>留空为不修改</i></td></tr>
        <tr><td style="text-align: right;"> 等 级 : <select name="level">
                          {foreach name='levelSelect' key=key item=value}
                          <option value="{@value->id}">{@value->level_name}</option>
                          {/foreach}
                          </select>
        </td></tr>
        <tr><td><a href="{$prev_url}" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="submit" class="submit" value="修改管理员" onclick="return checkUpdateForm();"></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}



</body>
</html>