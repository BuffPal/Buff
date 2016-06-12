<?php if (!defined('THINK_PATH')) exit();?><!-- 引入头文件 -->
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
<style type="text/css">
  .panel-heading{
    padding: 0;
  }
  .panel-title>a{
    height: 35px;
    line-height: 35px;
    font-size: 16px;
  }
  #accordion>div{
    margin-top: 0;
  }
  .panel-title>a{
    padding: 0;
  }
  .panel-body{
    padding:0 0 0 15px;
  }
  .panel-body>a{
    display: block;
    width: 100%;
    height: 25px;
    font-size: 14px;
    line-height: 25px;
    padding: 0;
    margin: 0;
    margin:1px auto;
    text-align: center;
    color: #888;
  }
</style>
      <!-- 手风琴栏目 -->
      <div class="col-md-12 p0">
         <div class="panel-group" id="accordion">

           <div class="panel panel-default">
             <div class="panel-heading">
               <h4 class="panel-title">
                 <a href="#collapse1" data-toggle="collapse" data-parent="#accordion" class="button button-block button-rounded button-large">视频管理</a>
               </h4>
             </div>
             <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body"> 
                    <a href="<?php echo U('Video/classify');?>" class="button button-block button-rounded button-large col-md-12" target="map">栏目列表</a>
                    <a href="<?php echo U('Video/addClassify');?>" class="button button-block button-rounded button-large col-md-12" target="map">添加栏目</a>
                    <a href="<?php echo U('Video/index');?>" class="button button-block button-rounded button-large col-md-12" target="map">视频列表</a>
                    <a href="<?php echo U('Video/add');?>" class="button button-block button-rounded button-large col-md-12" target="map">上传视频</a>
                </div>
             </div>
           </div>

           <div class="panel panel-default">
             <div class="panel-heading">
               <h4 class="panel-title">
                 <a href="#collapse2" data-toggle="collapse" data-parent="#accordion" class="button button-block button-rounded button-large">音乐管理</a>
               </h4>
             </div>
             <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    <a href="<?php echo U('Music/lists');?>" class="button button-block button-rounded button-large col-md-12" target="map">栏目列表</a>
                    <a href="<?php echo U('Music/addClassify');?>" class="button button-block button-rounded button-large col-md-12" target="map">添加栏目</a>
                    <a href="<?php echo U('Music/index');?>" class="button button-block button-rounded button-large col-md-12" target="map">音乐列表</a>
                    <a href="<?php echo U('Music/add');?>" class="button button-block button-rounded button-large col-md-12" target="map">上传音乐</a>
                </div>
             </div>
           </div>

           <div class="panel panel-default">
             <div class="panel-heading">
               <h4 class="panel-title">
                 <a href="#collapse3" data-toggle="collapse" data-parent="#accordion" class="button button-block button-rounded button-large">文章管理</a>
               </h4>
             </div>
             <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                  第3部分
                </div>
             </div>
           </div>

           <div class="panel panel-default">
             <div class="panel-heading">
               <h4 class="panel-title">
                 <a href="#collapse4" data-toggle="collapse" data-parent="#accordion" class="button button-block button-rounded button-large">会员管理</a>
               </h4>
             </div>
             <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                  第4部分
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
<script type="text/javascript">
  $('div.panel-body>a').click(function(){
    $(this).addClass('active').siblings('a').removeClass('active');
  })
</script>