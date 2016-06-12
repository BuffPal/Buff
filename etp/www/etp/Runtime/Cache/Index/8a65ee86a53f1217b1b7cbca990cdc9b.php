<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>音乐播放</title>
</head>

<body>
    <!-- 头部引入 -->
    <!-- 公用控制器地址 -->
<script type="text/javascript">
  var videoAjaxUrl = "<?php echo U('Common/videoAjax');?>";//视频播放器 Common控制器 调用 AJAX请求
  var musicAjaxUrl = "<?php echo U('Common/musicAjax');?>"//音乐播放器 Common控制器 调用 AJAX请求



</script>
<!-- bootstrap主要样式 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/bootstrap.min.css"  rel="stylesheet">
<!-- bootstrap自带模板 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/bootstrap-theme.min.css">
<!-- bootstrap按钮插件 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/buttons.css">
<!-- jquery视频播放插件样式 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/video-js.min.css">
<!-- 音乐播放器引入 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/jAudio.css">
<!-- nav头部自己的样式 -->
<link rel="stylesheet" type="text/css" href="/Public/css/Index/nav.css">

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a href="#" class="navbar-brand p0"><img src="/Public/images/Index/h_logo.png" alt="" style="height: 50px;"></a>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <form class="navbar-form navbar-left form-inline form-group hidden-xs " role="search" action="<?php echo U('Search/search');?>" method="post">
        <div class="input-group">
          <div class="input-group-addon">
            <select class="form-control" name="type">
              <option selected="selected" value="music">音乐</option>
              <option value="video">电影</option>
              <option value="article">文章</option>
            </select>
          </div>
          <input type="text" class="form-control" placeholder="请输入搜索内容" name="keyword">
          <div class="input-group-addon p0">
            <input type="submit" value="搜索">        
          </div>
        </div>
      </form>
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
        <input type="hidden" id="navTitle" value="<?php echo ($navTitle); ?>">
          <li><a href="<?php echo U('Index/index');?>">首页</a></li>
          <li><a href="#">咨询</a></li>
          <li><a href="<?php echo U('Article/index');?>">文章</a></li>
          <li><a href="<?php echo U('Music/details');?>">音乐</a></li>
          <li><a href="<?php echo U('Video/details');?>">视频</a></li>
          <li><a href="#">关于</a></li>
          <li class="loginOrRegister">
            <?php if(session('uid')): ?><!-- 这里以后用自定义标签改过来,现在暂时不会 -->
            <?php $path = M('userinfo')->where(array('uid'=>session('uid')))->getField('userpic'); ?>
              <div class="userBox">
                <div class="userPic">
                  <a href="<?php echo U('UserSetting/index');?>"><img src="<?php if($path): ?>/<?php echo ($path); else: ?>/Public/Images/Index/none.png<?php endif; ?>" class="navPic"></a>
                </div>
                <div class="logout">
                  <a href="<?php echo U('UserSetting/index');?>">个人中心</a>
                  <a href="<?php echo U('Common/logout');?>">退出用户</a>
                </div>
              </div>
            <?php else: ?>
              <span>
                <a href="<?php echo U('Login/login');?>">登陆</a> | <a href="<?php echo U('Login/register');?>">注册</a>
              </span><?php endif; ?>

          </li>
        </ul>
      </div>
    </div>
</nav>
    <!-- 音乐详细页样式 -->
    <link rel="stylesheet" type="text/css" href="/Public/css/Index/M_details.css">
    <div class="container p0" style="margin-top: 80px;">
        <div class="row">
            <!-- 手风琴分类 -->
            <div class="col-md-2 p0">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                 <a href="#collapse1" data-toggle="collapse" data-parent="#accordion">古典<span class="glyphicon glyphicon-chevron-up"></span></a>
               </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse in">
                            <div class="panel-body">
                                <ul class="lists">
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object active">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="/Public/images/Index/none.png" class="media-object">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <a href="#">排行榜</a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                 <a href="#collapse2" data-toggle="collapse" data-parent="#accordion">爵士<span class="glyphicon glyphicon-chevron-up"></span></a>
               </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                第2部分
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                 <a href="#collapse3" data-toggle="collapse" data-parent="#accordion">蓝调<span class="glyphicon glyphicon-chevron-up"></span></a>
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
                 <a href="#collapse4" data-toggle="collapse" data-parent="#accordion">朋克<span class="glyphicon glyphicon-chevron-up"></span></a>
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
            <!-- 主页面 就是右侧列表-->
            <div class="col-md-10 p0 main">
                <div class="row">
                    <p class="col-md-12">搜狗热歌</p>
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>　</th>
                                    <th>歌曲</th>
                                    <th>歌手</th>
                                    <th class="hidden-xs">热度</th>
                                    <th>　</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td><a href="#">浮夸</a></td>
                                    <td><a href="#">张三李四</a></td>
                                    <td class="hidden-xs"><span class="glyphicon glyphicon-fire"></span> 1280</td>
                                    <td class="OP">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        <span class="glyphicon glyphicon-play" mid='5'></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h4 class="loading hidden">加载中.....<span class="glyphicon glyphicon-refresh"></span></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 尾部引入 -->
    <script language=javascript>window.onerror=function(){return true;}</script> 
<!-- footer专用样式 -->
<link rel="stylesheet" type="text/css" href="/Public/css/Index/footer.css">
<!-- 页脚样式 -->
<footer class="footer ">
  <div class="container">
    <div class="row footer-top">
      <div class="col-sm-6 col-lg-6">
        <h4>
          <img src="/Public/images/Index/h_logo.png">
        </h4>
        <p>本站所有图片均来自互联网.在此感谢<a href="http://www.bootcss.com/">Bootstrap中文网</a>的开源协议:),希望不侵犯您的版权.以及感谢本网站所用的一切插件具体请自行<a href="http://www.baidu.com" target="_blank">度娘</a>.程序员都忘了~</p>
      </div>
      <div class="col-sm-6  col-lg-5 col-lg-offset-1 ">
        <div class="row about">
          <div class="col-xs-6">
            <h4>关于</h4>
            <ul class="list-unstyled">
              <li><a href="#">关于我们</a></li>
              <li><a href="#">历史发展</a></li>
              <li><a href="#">友情链接</a></li>
            </ul>
          </div>
          <div class="col-xs-6">
            <h4>联系方式</h4>
            <ul class="list-unstyled">
              <li><a href="#" target="_blank">新浪微博</a></li>
              <li><a href="#">电子邮件</a></li>
              <li><a href="#">各国电话</a></li>
              <li><a href="#">各国大使馆</a></li>
            </ul>
          </div>
          <div class="col-xs-6">
            <h4>旗下网站</h4>
            <ul class="list-unstyled">
              <li><a href="#" target="_blank">奇迹微博</a></li>
              <li><a href="#" target="_blank">奇迹论坛</a></li>
              <li><a href="#" target="_blank">奇迹博客</a></li>
              <li><a href="#" target="_blank">奇迹门户</a></li>
            </ul>
          </div>
          <div class="col-xs-6">
            <h4>快捷操作</h4>
            <ul class="list-unstyled">
              <li><a href="#" target="_blank">首页</a></li>
              <li><a href="#" target="_blank">关于</a></li>
              <li><a href="#" target="_blank">咨询</a></li>
              <li><a href="#" target="_blank">联系</a></li>
            </ul>
          </div>
        </div>

      </div>
    </div>
    <hr/>
    <div class="row footer-bottom">
      <ul class="list-inline text-center">
        <li><a href="#" target="_blank">京ICP备852654号</a></li><li>京公网安备85213679854126</li>
      </ul>
    </div>
  </div>
</footer>

<!-- 视频播放用的模态框 -->
<div id="modalVideo" class="modal fade" tabindex="-1">
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-header">
                        <button class="close" data-dismiss='modal'><span class="glyphicon glyphicon-remove"></span></button>
                        <h4 class="modal-title text-center" id="videonameModal">视频播放</h4>
                  </div>
                  <div class="modal-body">
                        <video id="video" class="video-js vjs-default-skin vjs-big-play-centered container"  controls preload="auto" data-setup='{}' poster="/Public/Images/test/poster.png">
                              <source src="/Public/video/test.mp4" type='video/mp4' id="videoSource" />
                        </video>
                  </div>
                  <div class="modal-footer">
                        <div class="button-group">
                            <a href="<?php echo U('Video/details');?>/id/" type="button" class="button button-pill button-primary  button-3d button-small" id="moreLook">查看更多</a>
                            <a href="<?php echo U('Video/details');?>/id/" type="button" class="button button-pill button-primary  button-3d button-small" id="moreComment">查看评论</a>
                        </div>
                  </div>
            </div>
      </div>
</div>

<!-- 音乐播放器 -->
<div id="musicBox" class="hidden-xs">
  <div class='jAudio--player'>
      <audio></audio>
      <div class='jAudio--ui'>
        <div class='jAudio--thumb'></div>
        <div class='jAudio--status-bar'>
          <div class='jAudio--details'></div>
          <div class='jAudio--volume-bar'></div>
          <div class='jAudio--progress-bar'>
            <div class='jAudio--progress-bar-wrapper'>
              <div class='jAudio--progress-bar-played'>
                <span class='jAudio--progress-bar-pointer'></span>
              </div>
            </div>
          </div>
          <div class='jAudio--time'>
            <span class='jAudio--time-elapsed'>00:00</span>
            <span class='jAudio--time-total'>00:00</span>
          </div>
        </div>
      </div>
  
      <div class='jAudio--controls'>
        <ul>
          <li><button class='btn' data-action='prev' id='btn-prev'><span></span></button></li>
          <li><button class='btn' data-action='play' id='btn-play'><span></span></button></li>
          <li><button class='btn' data-action='next' id='btn-next'><span></span></button></li>
        </ul>
      </div>
  </div>

  <span class="button-wrap  musicBoxShift buttonShadow">
    <button class="button button-circle button-raised button-primary" kaiguan="0">
      <i class="glyphicon glyphicon-music"></i>
    </button>
  </span>
</div>

<!-- 加载状态模态框 -->
<div id="modalAjax" class="modal fade" role="dialog" tabindex="-1" data-backdrop='static' data-keyboard='false'>
      <div class="modal-dialog">
            <div class="modal-content">
                  <div class="modal-body">
                  <h4>加载中.... <span class="glyphicon glyphicon-refresh"></span></h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-info progress-bar-striped active" style=""></div>
                    </div>
                  </div>
            </div>
      </div>
</div>

<!-- 提示效果框 -->
<div id="fade"><span></span></div>

<!-- Jquery 2.1.4 -->
<script type="text/javascript" src="/Public/js/plug-in/j.js"></script>
<!-- 自己的工具类 -->
<script type="text/javascript" src="/Public/js/plug-in/Tool.js"></script>
<!-- bootstrap主要js -->
<script type="text/javascript" src="/Public/js/plug-in/bootstrap.js"></script>
<!-- 一个弹性动画插件 图在js文件夹里面 -->
<script type="text/javascript" src="/Public/js/plug-in/jquery.easing.min.js"></script>
<!-- 视频播放插件 -->
<script type="text/javascript" src="/Public/js/plug-in/video.min.js"></script>
<!-- 音乐播放器引入 -->
<script type="text/javascript" src="/Public/js/plug-in/jaudio.js"></script>
<!-- 网页固定定位小插件 虽然只有2k -->
<script type="text/javascript" src="/Public/js/plug-in/jquery.pinBox.min.js"></script>
<script type="text/javascript">
  var videoDetails = "<?php echo U('Video/details');?>/id/";
</script>
<!-- footer专用js -->
<script type="text/javascript" src="/Public/js/Index/footer.js"></script>




<!-- 音乐器配置 -->
<script type="text/javascript">
  var musicData = {
    playlist: [
      {
        file: "/Public/music/Gavin Degraw-Fire.mp3",
        thumb: "/Public/images/author/fukua.jpg",
        trackName: "陈奕迅",
        trackArtist: "Tobu & Syndec",
/*        trackAlbum: "file",*/
      }
    ]
  }
 
$(".jAudio--player").jAudio(musicData);  
</script>


    <!-- 音乐详细页js代码 -->
    <script type="text/javascript" src="/Public/js/Index/M_details.js"></script>
</body>

</html>