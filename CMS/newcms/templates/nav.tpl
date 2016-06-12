<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="../style/admin.css">
  <script type="text/javascript" src="../js/admin_nav.js"></script>
</head>
<body id="main">
  <div class="map">
    <a href="admin.php" target="admin.php">内容管理</a>&gt;&gt;<a href="nav.php?action=show">导航管理</a>&gt;&gt;<strong id="strong">{$title}</strong>
  </div>
  <ol>
    <li><a href="nav.php?action=show" class="selected">导航列表<i class="icon-compass"></i></a></li>
    <li><a href="nav.php?action=add">添加导航<i class="icon-compass"></i></a></li>
    {if $update}
    <li><a href="nav.php?action=update&id={$id}">修改导航<i class="icon-compass"></i></a></li>
    {/if}
    {if $addchild}
    <li><a href="nav.php?action=addchild&id={$id}">新增子导航<i class="icon-compass"></i></a></li>
    {/if}
    {if $addOrigami}
    <li><a href="nav.php?action=addOrigami&id={$id}">新增子折纸<i class="icon-compass"></i></a></li>
    {/if}
  </ol>

  {if $show}
      <div id="navShow">
              <ul class="topNav">
                <li>一</li><li>二</li><li>三</li><li>四</li><li>五</li><li>六</li>
              </ul>
              <ul class="mainNav">
                {foreach name='ALLNav' key=key item=value}
                  <li><input type="text" value="{@value['nav_name']}" name="main{@value['id']}" class="text">
                  <a href="nav.php?action=update&id={@value['id']}">[修 改]</a>|<a href="nav.php?action=addchild&id={@value['id']}">[添 加]</a>
                  <ul class="child">
                      {foreach array=value.'child' key=k item=v}
                      <li><i class="icon-arrow-right"></i><input type="text" value="{@v['nav_name']}" class="textChild"><a href="nav.php?action=update&id={@v['id']}">[修改]</a>|<a href="nav.php?action=delete&id={@v['id']}" onclick="return confirm('确认删除?') ? true : false">[删除]</a></li>
                      {/foreach}
                  </ul>
                  </li>
                {/foreach}
              </ul>
      </div>
      <form action="">
        <div id="origami">
          <table>
            <tr><th>这里是折纸动画导航(粉色的)</th><th>折纸名称</th><th>折纸URL</th><th>操作</th></tr>
            <tr><td>序号</td><td>{$origamiMainName}</td><td></td><td><a href="nav.php?action=updateOrigami&id={$origamiMainId}"> 修 改 </a> | <a href="nav.php?action=addOrigami&id={$origamiMainId}"> 添加子折纸</a></td></tr>
            {foreach name='ALLOrigamiNav' key=key item=value}
            <tr><td><i class="icon-arrow-right"></i>{@key+1}</td>
                <td><input type="text" name="name[{@value->id}]" class="text" value="{@value->origami_name}"></td>
                <td><input type="text" name="url[{@value->id}] " class="text" value="{@value->origami_url}"></td>
                <td><a href="nav.php?action=updateOrigami&id={@value->id}"> 修 改 </a> | <a href="nav.php?action=deleteOrigami&id={@value->id}" onclick="return confirm('确认删除?') ? true : false"> 删 除 </a></td></tr>
            {/foreach}
          </table>
        </div>
      </form>
  {/if}

  
  {if $add}
    <div class="addTable">
      <form action="" method="post" name="add">
        <input type="hidden" name="pid" value="0">
        <table>
        <tr><td style="text-align: right;">导航名称:<input type="text" name="nav_name" class="text" ></td><td align="left"><i>不能小于2或大于20</i></td></tr>
        <tr><td style="text-align: right;">导航URL:<input type="text" name="nav_url" class="text"><i>不能大于20</i></td></tr>
        <tr><td><a href="nav.php?action=show" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addSubmit" class="submit" value="添加导航" ></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}
  
  {if $addchild}
    <div class="addTable">
      <form action="" method="post" name="add">
        <input type="hidden" name="pid" value="{$prev_id}">
        <table>
        <tr><td>上级导航 : <a href="{$prev_url}" id="father">{$prev_name}</a></td></tr>
        <tr><td style="text-align: right;">子导航名称:<input type="text" name="nav_name" class="text" ></td><td align="left"><i>不能小于2或大于20</i></td></tr>
        <tr><td style="text-align: right;">子导航URL:<input type="text" name="nav_url" class="text"><i>不能大于20</i></td></tr>
        <tr><td><a href="nav.php?action=show" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addSubmit" class="submit" value="添加子导航" ></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}
  
   {if $update}
     <div class="addTable">
      <form action="" method="post" name="checkFormUpdate">
        <input type="hidden" value="{$id}" name="id">
        <input type="hidden" value="{$prev_url}" name="prev_url">
        <table>
        <tr><td style="text-align: right;">导航名:<input type="text" name="nav_name" class="text" value="{$nav_name}"></td><td align="left"><i>正确</i></td></tr>
      <tr><td style="text-align: right;">导航URL:<input type="text" name="nav_url" class="text" value="{$nav_url}"></td></tr>
        <tr><td><a href="{$prev_url}" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="submit" class="submit" value="修改导航" ></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}

  {if $addOrigami}
    <div class="addTable">
      <form action="" method="post" name="add">
        <input type="hidden" name="pid" value="{$id}">
        <table>
        <tr><td style="text-align: right;">子折纸名称:<input type="text" name="origami_name" class="text" ></td><td align="left"><i>不能小于2或大于20</i></td></tr>
        <tr><td style="text-align: right;">子折纸URL:<input type="text" name="origami_url" class="text"><i>不能大于20</i></td></tr>
        <tr><td><a href="nav.php?action=show" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addOrigami" class="submit" value="添加子折纸" ></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}

   {if $updateOrigami}
     <div class="addTable">
      <form action="" method="post" name="checkFormUpdate">
        <input type="hidden" value="{$id}" name="id">
        <input type="hidden" value="{$prev_url}" name="prev_url">
        <table>
        <tr><td style="text-align: right;">子折纸名:<input type="text" name="origami_name" class="text" value="{$origami_name}"></td><td align="left"><i>正确</i></td></tr>
      <tr><td style="text-align: right;">子折纸URL:<input type="text" name="origami_url" class="text" value="{$origami_url}"></td></tr>
        <tr><td><a href="{$prev_url}" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="submit" class="submit" value="修改折纸" ></td><td></td></tr>
        </form>
      </table>
    </div>
  {/if}

  
</body>
</html>