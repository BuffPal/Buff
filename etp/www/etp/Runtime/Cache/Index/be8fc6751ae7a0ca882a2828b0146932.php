<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
</head>

<body>
    <!-- 头像上传裁剪插件 这里与bootstrap冲突了 这里让他放上面 在自己的样式在调-->
    <link rel="stylesheet" type="text/css" href="/Public/css/plug-in/cropbox.css">
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
    <link rel="stylesheet" type="text/css" href="/Public/css/Index/userSetting.css">
    <script type="text/javascript">
    var checkUsernameUrl = "<?php echo U('checkUsername');?>"; //AJAX验证用户昵称是否存在
    </script>
    <div class="container" id="userpic">
        <div class="row">
            <div class="col-md-12">
                <img src="<?php if($path): ?>/<?php echo ($path); else: ?>/Public/Images/Index/none.png<?php endif; ?>" class="userpic" data-toggle="modal" data-target="#modalPic">
            </div>
        </div>
    </div>
    <div class="container" id="userSetting">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default" style="margin-top: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                 <a href="#collapse1" class="button button-block button-rounded  button-large button-small" data-toggle="collapse" data-parent="#accordion">基本信息</a>
               </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <div class="container-fulid">
                            <form class="form-horizontal" action="<?php echo U('saveBasic');?>" method="post" name="save" id="save">
                                <div class="form-group">
                                    <label for="username" class="col-sm-5 control-label">用户昵称<i style="color: red;">*</i><em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="username" type="text" name="username" class="form-control text" placeholder="请输入您的昵称" value="<?php echo ($userinfo["username"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="truename" class="col-sm-5 control-label">真实名称<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="truename" type="text" name="truename" class="form-control text" placeholder="请输入您的真实昵称" value="<?php echo ($userinfo["truename"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">所在地<em>　:</em></label>
                                    <div id="city">
                                        <select class="prov" name="location[]"></select>
                                        <select class="city" disabled="disabled" name="location[]"></select>
                                        <select class="dist" disabled="disabled" name="location[]"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">性别<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="inlineRadio1" value="0" <?php if($userinfo["sex"]): else: ?>checked<?php endif; ?>> 男
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="sex" id="inlineRadio2" value="1" <?php if($userinfo["sex"]): ?>checked
                                            <?php else: endif; ?>> 女
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="truename" class="col-sm-5 control-label">生日<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <select id="select_year" rel="<?php echo ($userinfo["day"]["0"]); ?>" name="day[]"></select>年
                                        <select id="select_month" rel="<?php echo ($userinfo["day"]["1"]); ?>" name="day[]"></select>月
                                        <select id="select_day" rel="<?php echo ($userinfo["day"]["2"]); ?>" name="day[]"></select>日
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="intro" class="col-sm-5 control-label">一句话介绍自己<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <textarea name="intro" id="intro" class="form-control" placeholder=" 请不要超过 70 个字"><?php echo ($userinfo["intro"]); ?></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="intro" class="col-sm-5 control-label"><em></em></label>
                                    <div class="col-sm-12">
                                        <strong class="lianxi">联系信息</strong>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="blog" class="col-sm-5 control-label">博客地址<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="blog" type="text" name="blog" class="form-control text" placeholder="请输入博客地址" value="<?php echo ($userinfo["blog"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="msn" class="col-sm-5 control-label">MSN<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="msn" type="text" name="msn" class="form-control text" placeholder="请输入MSN地址" value="<?php echo ($userinfo["msn"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qq" class="col-sm-5 control-label">QQ<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="qq" type="text" name="qq" class="form-control text" placeholder="请输入QQ号" value="<?php echo ($userinfo["qq"]); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qq" class="col-sm-5 control-label"><em></em></label>
                                    <div class="col-sm-3">
                                        <button id="submita" class="button button-3d button-primary button-rounded">保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 第二部分 -->
            <div class="panel panel-default" style="margin-top: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                 <a href="#collapse2" class="button button-block button-rounded  button-large button-small" data-toggle="collapse" data-parent="#accordion">收藏的音乐</a>
               </h4>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                    <div class="panel-body">
                        暂未实现该功能
                    </div>
                </div>
            </div>
            <!-- 第三部分 -->
            <div class="panel panel-default" style="margin-top: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                 <a href="#collapse3" class="button button-block button-rounded  button-large button-small" data-toggle="collapse" data-parent="#accordion">收藏的电影</a>
               </h4>
                </div>
                <div id="collapse3" class="panel-collapse collapse">
                    <div class="panel-body">
                        暂未实现该功能
                    </div>
                </div>
            </div>
            <!-- 第四部分 -->
            <div class="panel panel-default" style="margin-top: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                 <a href="#collapse4" class="button button-block button-rounded  button-large button-small" data-toggle="collapse" data-parent="#accordion">收藏的文章</a>
               </h4>
                </div>
                <div id="collapse4" class="panel-collapse collapse">
                    <div class="panel-body">
                        暂未实现该功能
                    </div>
                </div>
            </div>
            <!-- 第五部分 -->
            <div class="panel panel-default" style="margin-top: 0;">
                <div class="panel-heading">
                    <h4 class="panel-title">
                 <a href="#collapse5" class="button button-block button-rounded  button-large button-small" data-toggle="collapse" data-parent="#accordion">修改密码</a>
               </h4>
                </div>
                <div id="collapse5" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="container-fulid">
                            <form class="form-horizontal" action="<?php echo U('revisePW');?>" method="post" name="revisePW" id="revisePW">
                                <div class="form-group">
                                    <label for="username" class="col-sm-5 control-label">电子邮箱<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="username" type="text" name="username" class="form-control text" disabled value="<?php echo ($email); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="oldPassword" class="col-sm-5 control-label">旧密码<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="oldPassword" type="password" name="oldPassword" class="form-control text" placeholder="请输入您的旧密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword" class="col-sm-5 control-label">新密码<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="newPassword" type="password" name="newPassword" class="form-control text" placeholder="请输入您的新密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newNotPassword" class="col-sm-5 control-label">确认密码<em>　:</em></label>
                                    <div class="col-sm-3">
                                        <input id="newNotPassword" type="password" name="newNotPassword" class="form-control text" placeholder="请再次确认您的密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-5 control-label"></label>
                                    <div class="col-sm-3">
                                        <input type="submit" value="修改" class="button button-3d button-primary button-rounded">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 头像上传专用模态框 -->
    <div class="modal  fade" id="modalPic" tabindex="-1">
        <div class="modal-dialog picDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal"><span>&times;</span></button>
                    <h4 class="modal-title text-center text-info">头像设置</h4>
                </div>
                <div class="modal-body picBody">
                    <div class="container-fulid">
                        <div class="imageBox">
                            <div class="thumbBox"></div>
                            <div class="spinner" style="display: none">Loading...</div>
                        </div>
                        <div class="action">
                            <!-- <input type="file" id="file" style=" width: 200px">-->
                            <div class="new-contentarea tc">
                                <a href="javascript:void(0)" class="upload-img">
                                    <label for="upload-file">上传图像</label>
                                </a>
                                <input type="file" class="" name="upload-file" id="upload-file" />
                            </div>
                            <input type="button" id="btnCrop" class="Btnsty_peyton" value="裁切">
                            <input type="button" id="btnZoomIn" class="Btnsty_peyton" value="+">
                            <input type="button" id="btnZoomOut" class="Btnsty_peyton" value="-">
                        </div>
                        <div class="cropped">
                            <img src="<?php if($path): ?>/<?php echo ($path); else: ?>/Public/Images/Index/none.png<?php endif; ?>" align="absmiddle" style="width:64px;margin-top:4px;border-radius:64px;box-shadow:0px 0px 12px #7E7E7E;">
                            <p>64px*64px</p>
                            <img src="<?php if($path): ?>/<?php echo ($path); else: ?>/Public/Images/Index/none.png<?php endif; ?>" align="absmiddle" style="width:128px;margin-top:4px;border-radius:128px;box-shadow:0px 0px 12px #7E7E7E;">
                            <p>128px*128px</p>
                            <img src="<?php if($path): ?>/<?php echo ($path); else: ?>/Public/Images/Index/none.png<?php endif; ?>" align="absmiddle" style="width:180px;margin-top:4px;border-radius:180px;box-shadow:0px 0px 12px #7E7E7E;">
                            <p>180px*180px</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <a class="button" data-toggle="modal" data-target="#modalPic">点击</a> -->
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


    <!-- 头像上传裁剪插件 -->
    <script type="text/javascript" src="/Public/js/plug-in/cropbox.js"></script>
    <script type="text/javascript">
    var path = "<?php echo ($path); ?>"; //数据库取出来的地址
    var uploadFaceUrl = "<?php echo U('Common/uploadFace');?>"; //后台ajax更新头像
    </script>
    <!-- 引入jquery.city城市联动 -->
    <script type="text/javascript">
    var cityselectUrl = '/Public/js/plug-in/city.min.js'; //引入城市联动需要的json数据
    var home = '<?php echo ($userinfo["location"]); ?>'; //用户的默认地址放这里,在city.js里面写了自动转换
    </script>
    <script type="text/javascript" src="/Public/js/plug-in/jquery.cityselect.js"></script>
    <script type="text/javascript">
    $("#city").citySelect(); //调用城市联动
    </script>
    <!-- 引入生日联动 也就是日期联动 -->
    <script type="text/javascript" src="/Public/js/plug-in/birthday.js"></script>
    <script type="text/javascript">
    $.ms_DatePicker({
        YearSelector: "#select_year",
        MonthSelector: "#select_month",
        DaySelector: "#select_day"
    });
    </script>
    <!-- validate验证 -->
    <script type="text/javascript" src="/Public/js/plug-in/validate.js"></script>
    <!-- 自己的js -->
    <script type="text/javascript" src="/Public/js/Index/userSetting.js"></script>
</body>

</html>