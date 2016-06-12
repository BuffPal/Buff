<?php if (!defined('THINK_PATH')) exit();?><style type="text/css">
div.left{
  float: left;
}
div.left>a>img{
  height: 80px;
  padding-left: 20px;
}
div.right{
  float: right;
  width: 80%;
  height: 100%;
}
div.minfo{
  height: 100%;
}
div.minfo span,div.minfo strong,div.minfo a{
  display:inline-block;
  float: right;
  height: 100%;
  line-height: 80px;
}
div.login{
  padding-top: 30px;
}
div.login>div{
  float: left;
  margin-left: 5%;
}
</style>
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

<div class="container-fulid">
  <div class="row">
    <div class="left">
      <a href="http://<?php echo ($_SERVER['SERVER_NAME']); ?>" target="_prenat">
        <img src="/Public/Images/Admin/h_logo.png" class="img img-rounded">
      </a>
    </div>
    <div class="right">
      <div class="container-fulid">
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-6">
            <div class="login">
              <div>
                <?php if(session("mlogintime") == 0): ?><strong>这是您第一次登录</strong>
                  <?php else: ?>
                    上次登录时间:<strong><?php echo (date('Y-m-d H:i:s',session('mlogintime'))); ?></strong><?php endif; ?>
                <br>
                本次登录时间:<strong><?php echo (date('Y-m-d H:i:s',session('mnlogintime'))); ?></strong>
              </div>

              <div>
                <br>
                该账号已登录 <em> [ <strong> <?php echo (session('mlogins')); ?> </strong> ] </em> 次
              </div>

              <div>
                <?php if(session("mlogintime") == 0): ?><strong>这是您第一次登录</strong>
                  <?php else: ?>
                    上次登录IP:<strong><?php echo (session('mloginip')); ?></strong><?php endif; ?>
                <br>
                本次登录IP:<strong><?php echo (session('mnloginip')); ?></strong>
              </div>
            </div>
          </div>
          <div class="col-md-3 minfo">
            <a href="<?php echo U('Common/logout');?>" target="_parent">[退出]</a>
            <a href="http://<?php echo ($_SERVER['SERVER_NAME']); ?>" target="_black">[ 首页 ]</a>
            <strong>[ 超级管理员 ]</strong>
            <span>admin　</span>
          </div>
        </div>
      </div>
    </div>
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