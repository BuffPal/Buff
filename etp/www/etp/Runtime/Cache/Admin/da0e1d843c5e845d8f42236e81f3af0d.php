<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>后台登录</title>
</head>
<body>
  <!-- 引入头文件 -->
  <!-- bootstrap主要样式 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/bootstrap.min.css"  rel="stylesheet">
<!-- bootstrap自带模板 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/bootstrap-theme.min.css">
<!-- bootstrap按钮插件 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/buttons.css">
<!-- 引入基本样式(常用的) -->
<link rel="stylesheet" type="text/css" href="/Public/css/Admin/basic.css">
<!-- 载入uploads上传插件CSS样式 -->
<link rel="stylesheet" type="text/css" href="/Public/Uploadify/uploadify.css">
<style type="text/css">
/**弹出效果**/
#fade{
  position:fixed;
  left: 40%;
  top: 38%;
  width: 200px;
  height: 40px;
  background: #fff;
  z-index: 9999;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0px 0px 10px #434343;
  display: none;
}
#fade>span{
  display: block;
  width: 100%;
  height: 40px;
  color: #FFFFFF;
  text-shadow: 1px 1px 2px #727272;
  font-size: 1.8rem;
  text-align: center;
  line-height: 40px;
}
</style>
<!-- Uploadify js定义 -->
<script type="text/javascript">
  var PUBLIC = "/Public";
  var uploadPosterUrl = "<?php echo U('Common/uploadVideoPoster');?>";//后台PHP处理地址


</script>

  <div class="container" style="margin-top: 120px;">
    <div class="row">
      <form class="col-md-12 form-horizontal" action="<?php echo U('checkLogin');?>" method="post">

        <div class="form-group">
          <label for="managename" class="col-sm-5 control-label">管理员账号<em>　:</em></label>
          <div class="col-sm-3">
            <input id="managename" type="text" name="account" class="form-control text" >
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="col-sm-5 control-label">管理员密码<em>　:</em></label>
          <div class="col-sm-3">
            <input id="password" type="password" name="password" class="form-control text" >
          </div>
        </div>

        <div class="form-group">
          <label for="verify" class="col-sm-5 control-label">请输入下图验证码<em>　:</em></label>
          <div class="col-sm-3">
            <input id="verify" type="text" name="verify" class="form-control text" >
          </div>
        </div>

        <div class="form-group">
          <label  class="col-sm-5 control-label"><em>　</em></label>
          <div class="col-sm-3">
            <img src="<?php echo U('verify');?>" onclick="javascript:this.src=this.src+'?'+Math.random()">
          </div>
        </div>

        <div class="form-group">
          <label  class="col-sm-5 control-label"><em>　</em></label>
          <div class="col-sm-3">
            <input type="submit" value="登录" class="button button-3d button-primary button-rounded">
          </div>
        </div>
        
      </form>
    </div>
  </div>

  <!-- 引入尾文件 -->
  <!-- 提示效果框 -->
<div id="fade"><span></span></div>










<!-- Jquery 2.1.4 -->
<script type="text/javascript" src="/Public/js/plug-in/j.js"></script>
<!-- 自己的工具类 -->
<script type="text/javascript" src="/Public/js/plug-in/Tool.js"></script>
<!-- bootstrap主要js -->
<script type="text/javascript" src="/Public/js/plug-in/bootstrap.js"></script>
<!-- 引入Upload上传插件 -->
<script type="text/javascript" src="/Public/Uploadify/jquery.uploadify.min.js"></script>
</body>
</html>