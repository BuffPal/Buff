<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../style/admin.css">
  <script type="text/javascript" src="../js/admin_level.js"></script>
</head>
<body id="main">
  <div class="map">
    <a href="admin.php" target="admin.php">管理首页</a>&gt;&gt;<a href="level.php?action=show">等级管理</a>&gt;&gt;<strong id="strong">{$title}</strong>
  </div>
  <ol>
    <li><a href="level.php?action=show" class="selected">等级列表<i class="icon-compass"></i></a></li>
    <li><a href="level.php?action=add">添加等级<i class="icon-compass"></i></a></li>
    {if $update}
    <li><a href="level.php?action=update">修改等级<i class="icon-compass"></i></a></li>
    {/if}
  </ol>
  {if $show}
  <table border="0" cellspacing="0">
    <tr><th style="width: 5%;">编号/序列</th><th style="width: 10%;">等级名称</th><th style="width: 25%;">等级描述</th><th style="width: 10%;">操作</th></tr>
    {if $ALLLevel}
    {foreach name='ALLLevel' key=key item=value}
    <tr>
      <td><script type="text/javascript">document.write({@key+1}+{$num})</script></td>
      <td>{@value->level_name}</td>
      <td>{@value->level_info}</td>
      <td><a href="level.php?action=update&id={@value->id}"> [ 修改 ] </a>|<a href="level.php?action=delete&id={@value->id}" onclick="return confirm('确认删除?') ? true : false"> [ 删除 ] </a></td>
    </tr>
    {/foreach}
      {else}
    <tr><td colspan="4"><i class="icon-quill"></i> 没 有 任 何 数  据 ! </td></tr>
    {/if}
  </table>
   <div id="page">
    {$page}
   </div>
  {/if}

  {if $add}
    <div class="addTable">
      <form action="" method="post" name="add">
        <table>
        <tr><td style="text-align: right;">等级名:<input type="text" name="level_name" class="text" ></td><td align="left"><i>不能小于2或大于20</i></td></tr>
        <tr><td style="text-align: right;">等级描述<textarea name="level_info"></textarea><i>不能大于20</i></td></tr>
        <tr><td><a href="level.php?action=show" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addSubmit" class="submit" value="添加等级" onclick="return checkForm();"></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}
  
  {if $update}
     <div class="addTable">
      <form action="" method="post" name="checkFormUpdate">
        <input type="hidden" value="{$id}" name="id">
        <input type="hidden" value="{$prev_url}" name="prev_url">
        <input type="hidden" value="{$level}" id="upData_level">
        <table>
        <tr><td style="text-align: right;">等级名:<input type="text" name="level_name" class="text" value="{$level_name}"></td><td align="left"><i>正确</i></td></tr>
      <tr><td style="text-align: right;">等级描述<textarea name="level_info">{$level_info}</textarea></td></tr>
        <tr><td><a href="{$prev_url}" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="submit" class="submit" value="修改等级" onclick="return checkFormUpdate();"></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}



</body>
</html>