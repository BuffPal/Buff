<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>网站后台</title>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/css/admin.css">
</head>
<frameset rows="80px,*" border='0'>
  <frame src="<?php echo U('header');?>" noresize="true" scrolling="no">
    <frameset cols="150px,*">
    <frame src="<?php echo U('sidebar');?>" name="sidebar" noresize="true"  scrolling="no">
    <frame src="<?php echo U('main');?>" name="map" noresize="true" >
  </frameset>
</frameset>
</html>