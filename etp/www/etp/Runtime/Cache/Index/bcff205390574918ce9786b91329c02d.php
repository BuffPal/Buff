<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>视频播放</title>
</head>
<script language=javascript>
window.onerror = function() {
    return true;
}
var topcountAjaxUrl = "<?php echo U('Video/topcountAjax');?>";//ajax点赞处理
</script>

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
          <li><a href="<?php echo U('Music/lists');?>">音乐</a></li>
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
    <!-- 视频详细页样式 -->
    <link rel="stylesheet" type="text/css" href="/Public/css/Index/V_details.css">
    <!-- 视频上面的vi   deo导航 -->
    <div id="listNav">
        <div class="container">
            <div class="col-md-12 top">
                <?php if($nav): if(is_array($nav)): foreach($nav as $key=>$v): ?><a href="<?php echo U('Video/lists',array('id'=>$v['id']));?>"><?php echo ($v["name"]); ?></a>
                        <?php if($navlength != $v["key"]): ?><strong>&gt;</strong><?php endif; endforeach; endif; endif; ?>
            </div>
            <div class="col-md-12 bottom"><a href="<?php echo U('lists',array('id'=>$nav[$navlength-1]['id']));?>"><?php echo ($nav[$navlength-1]['name']); ?></a>:<?php echo ($data["videoname"]); ?></div>
        </div>
    </div>
    <!-- 视频主要播放区 -->
    <div id="videoPlayer">
        <div class="container">
            <div class="col-md-9 videoBox">
                <video id="video2" class="video-js vjs-default-skin vjs-big-play-centered container" controls preload="auto" data-setup='{}' poster="<?php echo ($data["videopicurl"]); ?>">
                    <source src="<?php echo ($data["videourl"]); ?>" type='video/mp4; codecs="avc1.4D401E, mp4a.40.2"' class="source" />
                </video>
            </div>
            <div class="col-md-3 list">
                <ul class="title">
                    <li>选集</li>
                </ul>
                <ul class="data">
                    <?php if($sdata): if(is_array($sdata)): foreach($sdata as $key=>$v): ?><li>
                                <a href="<?php echo U('details',array('id'=>$v['id']));?>">
                                    <div class="top"><b><?php echo ($key+1); ?></b><span><?php echo ($v["videoname"]); ?></span></div>
                                    <div class="bottom"><span class="glyphicon glyphicon-play"></span><?php echo (getNum($v["playcount"])); ?></div>
                                </a>
                            </li><?php endforeach; endif; ?>
                        <?php else: ?>
                        <li>当前分类没有其他视频~</li><?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- 视频操作区 -->
    <div id="OP">
        <div class="container">
            <div class="col-md-9">
                <div class="col-md-9">
                    <div class="button-group">
                        <button type="button" class="button button-pill button-royal button-small button-3d" id="topcount" videoid='<?php echo ($data["id"]); ?>'>
                            <i class="glyphicon glyphicon-thumbs-up"> <?php echo (getNum($data["topcount"])); ?></i>
                        </button>
                        <button type="button" class="button button-pill button-royal button-small button-3d" uid='<?php echo (session('uid')); ?>'>
                            <i class="glyphicon glyphicon-star"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 right">
                    <span class="glyphicon glyphicon-expand">&nbsp;<?php echo (getNum($data["playcount"])); ?></span>
                    <a href="#" class="glyphicon glyphicon-comment"> <?php echo (getNum($data["comment"])); ?></a>
                </div>
            </div>
            <div class="col-m-3">　</div>
        </div>
    </div>
    <!-- 排行榜+用户评论+相关推荐 -->
    <div class="warp container">
        <!-- 左侧 -->
        <div id="left" class="col-md-9">
            <blockquote class="container-fluid">
                大家都在看
            </blockquote>
            <div class="listTop container-fluid">
                <div class="row p0 m0">
                    <?php if($hotVideo): if(is_array($hotVideo)): foreach($hotVideo as $key=>$v): ?><div class="col-md-2">
                                <div class="imgBox">
                                    <div class="visible-xs-block">
                                        <a href="#"><i class="glyphicon glyphicon-play-circle"></i></a>
                                    </div>
                                    <img src="<?php echo ($v["videopicurl176"]); ?>" class="img-responsive">
                                    <span class="glyphicon glyphicon-play-circle hidden-xs href" href="<?php echo U('details',array('id'=>$v['id']));?>"></span>
                                    <div class="zhezhao hidden-xs">
                                        <b class="tI4"><?php echo ($v["videoname"]); ?></b>
                                        <div style="top:75%;">
                                            <i class="glyphicon glyphicon-play"></i> <strong><?php echo ($v["playcount"]); ?></strong>
                                        </div>
                                    </div>
                                    <?php if($v["isday"] == 1): ?><div class="today">
                                            今日
                                        </div><?php endif; ?>
                                </div>
                            </div><?php endforeach; endif; ?>
                        <?php else: ?>
                        <h5>暂时木有数据~</h5><?php endif; ?>
                </div>
            </div>
            <!-- 评论输入区块 -->
            <div class="comment container-fluid">
                <div class="lr">
                    <a href="#">登陆</a>
                    <strong>|</strong>
                    <a href="#">注册</a>
                </div>
                <div class="commentInput">
                    <textarea name="comment" class="form-control">
                        请自由发挥
                    </textarea>
                    <div class="OP container-fluid">
                        <div class="pic col-md-10">
                            <span class="glyphicon glyphicon-picture"></span>
                        </div>
                        <div class="col-md-2">
                            <button class="button button-3d button-primary button-rounded button-tiny">发布</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 评论显示列表 -->
            <div class="container-fluid commentList">
                <ul class="col-xs-12 media-list">
                    <li class="media">
                        <div class="media-left">
                            <a href="#"><img src="/Public/images/Index/none.png" class="media-object"></a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#">依然是张三</a></h4>
                            <div class="content">
                                <p>今天天气不错哈!今天天气不错哈!今天天气不错哈!今天天气不错哈!</p>
                                <div class="footer">
                                    <p>6小时前</p>
                                    <div class="button-group">
                                        <button type="button" class="button button-3d button-primary button-rounded button-tiny">
                                            <i class="glyphicon glyphicon-thumbs-up"> 1024</i>
                                        </button>
                                        <button type="button" class="button button-3d button-primary button-rounded button-tiny">
                                            <i class="glyphicon glyphicon-comment"> 1840</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <ul class="col-xs-12 media-list">
                    <li class="media">
                        <div class="media-left">
                            <a href="#"><img src="/Public/images/Index/none.png" class="media-object"></a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#">依然是张三</a></h4>
                            <div class="content">
                                <p>今天天气不错哈!今天天气不错哈!今天天气不错哈!今天天气不错哈!</p>
                                <div class="footer">
                                    <p>6小时前</p>
                                    <div class="button-group">
                                        <button type="button" class="button button-3d button-primary button-rounded button-tiny">
                                            <i class="glyphicon glyphicon-thumbs-up"> 1024</i>
                                        </button>
                                        <button type="button" class="button button-3d button-primary button-rounded button-tiny">
                                            <i class="glyphicon glyphicon-comment"> 1840</i>
                                        </button>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#"><img src="/Public/images/Index/none.png" class="media-object"></a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><a href="#">依然是张三</a></h4>
                                        <div class="content">
                                            <p>今天天气不错哈!今天天气不错哈!今天天气不错哈!今天天气不错哈!</p>
                                            <div class="footer">
                                                <p>6小时前</p>
                                                <div class="button-group">
                                                    <button type="button" class="button button-3d button-primary button-rounded button-tiny">
                                                        <i class="glyphicon glyphicon-thumbs-up"> 1024</i>
                                                    </button>
                                                    <button type="button" class="button button-3d button-primary button-rounded button-tiny">
                                                        <i class="glyphicon glyphicon-comment"> 1840</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- 右侧 -->
        <div id="right" class="col-md-3">
            <blockquote class="container-fluid">相关视频</blockquote>
            <div class="col-xs-12 media-list">
                <?php if($xgdata): if(is_array($xgdata)): foreach($xgdata as $key=>$v): ?><div class="media">
                            <div class="media-left">
                                <a href="<?php echo U('details',array('id'=>$v['id']));?>">
                                    <img src="<?php echo ($v["videopicurl176"]); ?>" class="media-object">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="<?php echo U('details',array('id'=>$v['id']));?>"><?php echo ($v["videoname"]); ?></a></h4>
                                <div class="content">
                                    <div class="auther">
                                    </div>
                                    <div class="count">
                                        <span class="glyphicon glyphicon-play"><?php echo (getNum($v["playcount"])); ?></span>
                                        <a href="<?php echo U('details',array('id'=>$v['id']));?>">
                                            <sapn class="glyphicon glyphicon-comment"><?php echo ($v["comment"]); ?></sapn>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>
                <?php else: ?>
                    <h3>暂时木有数据~</h3><?php endif; ?>
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




<!-- 音乐器配置  下面是获取最新的一条音乐-->
<?php $mastNew = M('music')->field(array('id','musicname','author','musicurl','musicbgurl','cid'))->order('uploadtime DESC')->limit('1')->select(); $classify = M('musicclassify')->where(array('id'=>$mastNew[0]['cid']))->getField('name'); $mastNew[0]['classifyname'] = $classify; ?>
<script type="text/javascript">
  var musicData = {
    playlist: [
      {
        file: "<?php echo ($mastNew["0"]["musicurl"]); ?>",
        thumb: "<?php echo ($mastNew["0"]["musicbgurl"]); ?>",
        trackName: "<?php echo ($mastNew["0"]["musicname"]); ?>",
        trackArtist: "<?php echo ($mastNew["0"]["classifyname"]); ?> & <?php echo ($mastNew["author"]); ?>"
/*        trackAlbum: "file",*/
      }
    ]
  }
 
$(".jAudio--player").jAudio(musicData);  
</script>


    <!-- 视频详细页js代码 -->
    <script type="text/javascript" src="/Public/js/Index/V_details.js"></script>
</body>

</html>