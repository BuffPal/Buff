<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
</head>

<body>
    <!-- 头部 -->
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
    <!-- 自己的样式 -->
    <link rel="stylesheet" type="text/css" href="/Public/css/Index/register.css">
    <script type="text/javascript">
    var checkAjaxUrl = "<?php echo U('checkAjax');?>"; //ajax验证账号是否存在
    </script>
    <div class="container main">
        <div class="row">
            <div class="col-md-5 info hidden-xs ">
                <img src="/Public/images/Index/register/google.png">
                <div class="row-fluid">
                    <div class="span12">
                        <h2>
              欢迎加入
            </h2>
                        <p>
                            这里是谷歌公司旗下的奇迹公司,我们是最大的股东之一!加入我们,我们正在招贤纳士.我们更懂程序猿.
                        </p>
                        <p>
                            <a class="button button-raised button-primary button-pill" href="#">关于我们 »</a>
                        </p>
                    </div>
                </div>
            </div>
            <form action="<?php echo U('checkRegister');?>" method="post" class="form-horizontal col-md-5" name="register" id="register">
                <div class="form-group">
                    <label for="account" class="col-sm-6 control-label">账号<em>*</em></label>
                    <div class="col-sm-6">
                        <input id="account" type="text" name="account" class="form-control text" placeholder="请输入您的账号">
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-6 control-label">用户名<em>*</em></label>
                    <div class="col-sm-6">
                        <input type="text" id="username" name="username" class="form-control text" placeholder="请输入您的昵称">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-6 control-label">密码<em>*</em></label>
                    <div class="col-sm-6">
                        <input type="password" id="password" name="password" class="form-control text" placeholder="请输入您的密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="notPassword" class="col-sm-6 control-label">确认密码<em>*</em></label>
                    <div class="col-sm-6">
                        <input type="password" id="notPassword" name="notPassword" class="form-control text" placeholder="请确认您的密码">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-6 control-label">邮箱<em>*</em></label>
                    <div class="col-sm-6">
                        <input type="text" id="email" name="email" class="form-control text" placeholder="请确认您的邮箱">
                    </div>
                </div>
                <div class="form-group">
                    <label for="verify" class="col-sm-6 control-label">请输入下面验证码<em>*</em></label>
                    <div class="col-sm-6">
                        <input type="text" id="verify" name="verify" class="form-control text" placeholder="不区分大小写">
                        <p></p>
                        <img src="<?php echo U('verify');?>" class="verify" onclick="javascript:this.src='<?php echo U('verify');?>?' + Math.random();">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-6 control-label">　</label>
                    <div class="col-sm-6">
                        <button id="submita" class="button button-3d button-primary button-rounded">注册</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="img2" style="background-image: url('/Public/Images/Index/register/2.jpg')"></div>
        <div id="img" class="img" style="background-image: url('/Public/Images/Index/register/1.jpg')"></div>
    </div>
    <!-- 尾部 -->
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


    <!-- 验证插件vaildata(单独引入) -->
    <script type="text/javascript" src="/Public/js/plug-in/validate.js"></script>
    <!-- 自己的js -->
    <script type="text/javascript" src="/Public/js/Index/register.js"></script>
</body>

</html>