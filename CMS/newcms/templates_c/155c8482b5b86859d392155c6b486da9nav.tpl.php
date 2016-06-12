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
    <a href="admin.php" target="admin.php">内容管理</a>&gt;&gt;<a href="nav.php?action=show">导航管理</a>&gt;&gt;<strong id="strong"><?php echo $this->_vars['title'];?></strong>
  </div>
  <ol>
    <li><a href="nav.php?action=show" class="selected">导航列表<i class="icon-compass"></i></a></li>
    <li><a href="nav.php?action=add">添加导航<i class="icon-compass"></i></a></li>
    <?php if ($this->_vars['update']) {?>
    <li><a href="nav.php?action=update&id=<?php echo $this->_vars['id'];?>">修改导航<i class="icon-compass"></i></a></li>
    <?php } ?>
    <?php if ($this->_vars['addchild']) {?>
    <li><a href="nav.php?action=addchild&id=<?php echo $this->_vars['id'];?>">新增子导航<i class="icon-compass"></i></a></li>
    <?php } ?>
    <?php if ($this->_vars['addOrigami']) {?>
    <li><a href="nav.php?action=addOrigami&id=<?php echo $this->_vars['id'];?>">新增子折纸<i class="icon-compass"></i></a></li>
    <?php } ?>
  </ol>

  <?php if ($this->_vars['show']) {?>
      <div id="navShow">
              <ul class="topNav">
                <li>一</li><li>二</li><li>三</li><li>四</li><li>五</li><li>六</li>
              </ul>
              <ul class="mainNav">
                <?php foreach ($this->_vars['ALLNav'] as $key=>$value) { ?>
                  <li><input type="text" value="<?php echo $value['nav_name']?>" name="main<?php echo $value['id']?>" class="text">
                  <a href="nav.php?action=update&id=<?php echo $value['id']?>">[修 改]</a>|<a href="nav.php?action=addchild&id=<?php echo $value['id']?>">[添 加]</a>
                  <ul class="child">
                      <?php foreach ($value['child'] as $k=>$v) { ?>
                      <li><i class="icon-arrow-right"></i><input type="text" value="<?php echo $v['nav_name']?>" class="textChild"><a href="nav.php?action=update&id=<?php echo $v['id']?>">[修改]</a>|<a href="nav.php?action=delete&id=<?php echo $v['id']?>" onclick="return confirm('确认删除?') ? true : false">[删除]</a></li>
                      <?php } ?>
                  </ul>
                  </li>
                <?php } ?>
              </ul>
      </div>
      <form action="">
        <div id="origami">
          <table>
            <tr><th>这里是折纸动画导航(粉色的)</th><th>折纸名称</th><th>折纸URL</th><th>操作</th></tr>
            <tr><td>序号</td><td><?php echo $this->_vars['origamiMainName'];?></td><td></td><td><a href="nav.php?action=updateOrigami&id=<?php echo $this->_vars['origamiMainId'];?>"> 修 改 </a> | <a href="nav.php?action=addOrigami&id=<?php echo $this->_vars['origamiMainId'];?>"> 添加子折纸</a></td></tr>
            <?php foreach ($this->_vars['ALLOrigamiNav'] as $key=>$value) { ?>
            <tr><td><i class="icon-arrow-right"></i><?php echo $key+1?></td>
                <td><input type="text" name="name[<?php echo $value->id?>]" class="text" value="<?php echo $value->origami_name?>"></td>
                <td><input type="text" name="url[<?php echo $value->id?>] " class="text" value="<?php echo $value->origami_url?>"></td>
                <td><a href="nav.php?action=updateOrigami&id=<?php echo $value->id?>"> 修 改 </a> | <a href="nav.php?action=deleteOrigami&id=<?php echo $value->id?>" onclick="return confirm('确认删除?') ? true : false"> 删 除 </a></td></tr>
            <?php } ?>
          </table>
        </div>
      </form>
  <?php } ?>

  
  <?php if ($this->_vars['add']) {?>
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
  <?php } ?>
  
  <?php if ($this->_vars['addchild']) {?>
    <div class="addTable">
      <form action="" method="post" name="add">
        <input type="hidden" name="pid" value="<?php echo $this->_vars['prev_id'];?>">
        <table>
        <tr><td>上级导航 : <a href="<?php echo $this->_vars['prev_url'];?>" id="father"><?php echo $this->_vars['prev_name'];?></a></td></tr>
        <tr><td style="text-align: right;">子导航名称:<input type="text" name="nav_name" class="text" ></td><td align="left"><i>不能小于2或大于20</i></td></tr>
        <tr><td style="text-align: right;">子导航URL:<input type="text" name="nav_url" class="text"><i>不能大于20</i></td></tr>
        <tr><td><a href="nav.php?action=show" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addSubmit" class="submit" value="添加子导航" ></td><td></td></tr>
        </form>
      </table>
    </div>
  <?php } ?>
  
   <?php if ($this->_vars['update']) {?>
     <div class="addTable">
      <form action="" method="post" name="checkFormUpdate">
        <input type="hidden" value="<?php echo $this->_vars['id'];?>" name="id">
        <input type="hidden" value="<?php echo $this->_vars['prev_url'];?>" name="prev_url">
        <table>
        <tr><td style="text-align: right;">导航名:<input type="text" name="nav_name" class="text" value="<?php echo $this->_vars['nav_name'];?>"></td><td align="left"><i>正确</i></td></tr>
      <tr><td style="text-align: right;">导航URL:<input type="text" name="nav_url" class="text" value="<?php echo $this->_vars['nav_url'];?>"></td></tr>
        <tr><td><a href="<?php echo $this->_vars['prev_url'];?>" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="submit" class="submit" value="修改导航" ></td><td></td></tr>
        </form>
      </table>
    </div>
  <?php } ?>

  <?php if ($this->_vars['addOrigami']) {?>
    <div class="addTable">
      <form action="" method="post" name="add">
        <input type="hidden" name="pid" value="<?php echo $this->_vars['id'];?>">
        <table>
        <tr><td style="text-align: right;">子折纸名称:<input type="text" name="origami_name" class="text" ></td><td align="left"><i>不能小于2或大于20</i></td></tr>
        <tr><td style="text-align: right;">子折纸URL:<input type="text" name="origami_url" class="text"><i>不能大于20</i></td></tr>
        <tr><td><a href="nav.php?action=show" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="addOrigami" class="submit" value="添加子折纸" ></td><td></td></tr>
        </form>
      </table>
    </div>
  <?php } ?>

   <?php if ($this->_vars['updateOrigami']) {?>
     <div class="addTable">
      <form action="" method="post" name="checkFormUpdate">
        <input type="hidden" value="<?php echo $this->_vars['id'];?>" name="id">
        <input type="hidden" value="<?php echo $this->_vars['prev_url'];?>" name="prev_url">
        <table>
        <tr><td style="text-align: right;">子折纸名:<input type="text" name="origami_name" class="text" value="<?php echo $this->_vars['origami_name'];?>"></td><td align="left"><i>正确</i></td></tr>
      <tr><td style="text-align: right;">子折纸URL:<input type="text" name="origami_url" class="text" value="<?php echo $this->_vars['origami_url'];?>"></td></tr>
        <tr><td><a href="<?php echo $this->_vars['prev_url'];?>" style="font-size: 16px;">[ 返回列表 ]</a><input type="submit" name="submit" class="submit" value="修改折纸" ></td><td></td></tr>
        </form>
      </table>
    </div>
  <?php } ?>

  
</body>
</html>