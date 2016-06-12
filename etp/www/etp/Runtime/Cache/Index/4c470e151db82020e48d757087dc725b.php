<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="pragma" content="no-cache">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>奇迹公司</title>
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
  <!-- 自己的样式 -->
  <link rel="stylesheet" type="text/css" href="/Public/css/Index/index.css">
  <!-- 轮播图 -->
  <div id="myCarousel" class="carousel slide">
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active" style="background: #130D1B;">
          <img src="/Public/images/Index/carousel/1.png">
          <div class="carousel-caption ">
            <h3 class="hidden-xs"><a href="#">桥梁</a></h3>
            <p class="hidden-xs">桥梁，一般指架设在江河湖海上，使车辆行人等能顺利通行的构筑物。为适应现代高速发展的交通行业，桥梁亦引申为跨越山涧、不良地质或满足其他交通需要而架设的使通行更加便捷的建筑物。</p>
          </div>
        </div>
        <div class="item" style="background: #2D152D">
          <img src="/Public/images/Index/carousel/2.png">
          <div class="carousel-caption ">
            <h3 class="hidden-xs"><a href="#">公路</a></h3>
            <p class="hidden-xs">公路的字面含义是公用之路、公众交通之路，汽车、单车、人力车、马车等众多交通工具及行人都可以走，当然不同公路限制不同。民间也称作马路，如“马路天使”里的用法，不限于马匹专用。</p>
          </div>
        </div>
        <div class="item" style="background: #131C2E">
          <img src="/Public/images/Index/carousel/3.png">
          <div class="carousel-caption ">
            <h3 class="hidden-xs">荷叶</h3>
            <p class="hidden-xs">荷叶，又称莲花茎、莲茎。莲科莲属多年生草本挺水植物，古称芙蓉、菡萏、芙蕖。荷花一般长到150厘米高，横向扩展到3米。荷叶最大可达直径60厘米，莲花最大直径可达20厘米。荷花有许多不同的栽培品种，花色从雪白、黄色到淡红色及深黄色和深红色，其外还有分洒锦等等花色。</p>
          </div>
        </div>
        <div class="item" style="background: #D3A266">
          <img src="/Public/images/Index/carousel/4.png">
          <div class="carousel-caption ">
            <h3 class="hidden-xs">树木</h3>
            <p class="hidden-xs">树木是由“枝”和“杆”还有“叶”呈现的一种植物，可存活几十年。一般将乔木称为树，有明显直立的主干，植株一般高大，分枝距离地面较高，可以形成树冠。树有很多种， 俗语中也有将比较大的灌木称为“树”的，如石榴树、茶树等。</p>
          </div>
        </div>
      </div>
      <a href="#myCarousel" data-slide="prev" class="carousel-control left">
        <span class="glyphicon glyphicon-chevron-left"> </span>
      </a>
      <a href="#myCarousel" data-slide="next" class="carousel-control right">
        <span class="glyphicon glyphicon-chevron-right"> </span>
      </a>
  </div>

  <!-- 每日必读 -->
  <div id="read">
    <div class="container">
      <div class="col-md-9 col-sm-9">
        <blockquote class="container-fluid header">
          <strong class="col-md-11 col-xs-8 ">每日散文</strong>
          <div class="col-md-1">
            <button class="button button-raised  button-circle button-small">
              <span class="glyphicon glyphicon-refresh"></span>
            </button>
          </div>  
        </blockquote>
        <div class="container-fluid title">
          <h3 class="text-center">听雨</h3>
        </div>
        <div class="container-fluid content">
          <p>今年的广东雨水特别多，像是爱啼哭的三月婴儿，走着走着就下了，说着说着就停了，笑着笑着又开始下了。于是，次日一早，路两边到处是深深浅浅的水坑。许多行人是极不喜欢这种说来就来，千变万化的雨的。每日清晨，随处可见三三两两的行人吃力的推着摩托车，电单车在水里淌过，嘴角还不停的絮絮叨叨。 然后，我却是极喜欢这春雨的，尤其是登上高高的楼顶，可以慵懒的将头枕在窗柩上，放空一切，什么都不去想，肆无忌惮的隔空听雨。你听，雨是有声音的。它的声音极其的好听，细细柔柔的，它就像远处寺庙传来的钟响，声声扣响我的心扉。一个人静坐，观雨不语，前世，今生，患得，患失。它就像是梨园女子的吟唱声，水袖拂动，眉宇间顾盼生辉，婉转清脆中透着那么一丝凄凉，奏出一曲萧瑟和鸣对。诉不尽的缠绵绯侧，惹碎了满园关不住的春色。它就像涓涓流淌着山间小溪，清清的，凉凉的，丝丝入扣，流进了我的心坎里。眉头的结渐渐舒展了。嘴唇在不经意间上扬。是呀，雨一来，带来了人世间的一场温凉。雨蒙蒙的影影绰绰勾勒出漫天的浓淡墨色。雨的姿态也是极其好看的，温柔时像极了阿娜多姿，婷婷玉立的少女，它永远那么宁静的守候在世界的某个角落里，像千丝万缕的珠帘一样纷纷而落，似乎只有这样永不停止的飘落，它那思念着的远方人儿才能听得到，看得见。
          </p>
        </div>
        <div class="container-fluid">
          <button class="button button-3d button-primary button-rounded btn-right button-tiny">阅读全部</button>
        </div>
      </div>
      <div class="col-md-3 col-sm-3 newsC hidden-xs "><!-- newsContent -->
        <div class="pinBox">
          <span class="title h4">
            最新动态
          </span>
          <ol class="newsCList">
            <li><span>1. </span><a href="#">像千丝万缕的珠帘</a></li>
            <li><span>2. </span><a href="#">像千丝万缕的珠帘</a></li>
            <li><span>3. </span><a href="#">像千丝万缕的珠帘</a></li>
            <li><span>4. </span><a href="#">像千丝万缕的珠帘</a></li>
            <li><span>5. </span><a href="#">像千丝万缕的珠帘</a></li>
            <li><span>6. </span><a href="#">像千丝万缕的珠帘</a></li>
            <li><span>7. </span><a href="#">像千丝万缕的珠帘</a></li>
            <li><span>8. </span><a href="#">像千丝万缕的珠帘</a></li>
          </ol>
        </div>
      </div>
    </div>
  </div>


<!-- 最新 电影 粤剧 音乐 朗诵 http://www.17sucai.com/preview/229782/2015-10-23/大风车/index.html -->

<div id="newsV"><!-- newsVideo -->
  <div class="container">
    <blockquote class="container-fluid header p0 m0">
      <h4 class="col-md-8 col-sm-7 col-xs-12 mtb0">
        <img src="/Public/images/Index/news/1.png">
        <span>最新视频</span>
        <a href="#" class="button button-raised  button-tiny button-pill ua">更 多</a>
      </h4>
      <div class="col-md-4 col-sm-5 hidden-xs">
        <div class="button-group">
          <button type="button" class="button  button-tiny button-rounded button-raised">电 影</button>
          <button type="button" class="button  button-tiny button-rounded button-raised">演 唱</button>
          <button type="button" class="button  button-tiny button-rounded button-raised">小 品</button>
        </div>
      </div>
    </blockquote>

    <div class="container-fluid vbody">
      <div class="row">
  
        <?php if($newVideo): if(is_array($newVideo)): foreach($newVideo as $key=>$v): ?><div class="col-md-2 col-sm-3 col-xs-12">
              <div class="imgBox">
                <div class="hd visible-xs-block">
                  <a href="<?php echo U('Video/details',array('id'=>$v['id']));?>"><i class="glyphicon glyphicon-play-circle"></i></a>
                </div>
                <img src="<?php echo ($v["videopicurl176"]); ?>" class="img-responsive">
                <span class="glyphicon glyphicon-play-circle hidden-xs" vid="<?php echo ($v["id"]); ?>"></span>
                <div class="zhezhao hidden-xs">
                  <b class="tI4"><?php echo ($v["videoname"]); ?></b>
                  <div>
                    <i class="glyphicon glyphicon-play"></i> <strong><?php echo ($v["playcount"]); ?></strong>
                  </div>
                </div>
                <?php if($v['isday'] == 1): ?><div class="today">
                    今日
                  </div><?php endif; ?>
              </div>
            </div><?php endforeach; endif; ?>
        <?php else: ?>
          <h2>暂没有数据</h2><?php endif; ?>

      </div>
    </div>
  </div>
</div>



<!-- 最新音乐 -->
<div class="musicTitle container">
  <div class="row">
    <blockquote class="col-md-4 col-sm-6">
      <span>最新推荐</span>
      <a href="#" class="button button-glow button-circle button-primary button-tiny">
        <i class="glyphicon glyphicon-plus"></i>
      </a>
    </blockquote>
    <blockquote class="col-md-4 col-sm-6 hidden-xs">
      <span>最热推荐</span>
      <a href="#" class="button button-glow button-circle button-primary button-tiny">
        <i class="glyphicon glyphicon-plus"></i>
      </a>
    </blockquote>
    <blockquote class="col-md-4 col-sm-6 hidden-xs hidden-sm">
      <span>历史排行</span>
      <a href="#" class="button button-glow button-circle button-primary button-tiny">
        <i class="glyphicon glyphicon-plus"></i>
      </a>
    </blockquote>
  </div>
</div>

<section id="musicList" class="parallax parallax-2 container p0" style="background-image: url('/Public/images/Index/news/music.jpg');">
  <div class="container-fluid p0">
    <div class="row m0">
      <!-- 左边 -->
      <div class="col-md-4 col-sm-6 p0">
        <div class="container-fluid">
          <div class="row list">
            <?php if($newMusic): if(is_array($newMusic)): foreach($newMusic as $key=>$v): ?><div class="col-md-12">
                      <span>
                        <a href="#"><?php echo ($v["musicname"]); ?></a>
                        <strong>－</strong>
                        <a href="#"><?php echo ($v["author"]); ?></a>
                      </span>
                      <i class="glyphicon glyphicon-plus-sign"></i>
                      <i class="visible-xs-block">
                        <a href="#" class="glyphicon glyphicon-play-circle"></a>
                      </i>
                      <i class="glyphicon glyphicon-play-circle hidden-xs" mid='<?php echo ($v["id"]); ?>'></i>
                </div><?php endforeach; endif; endif; ?>
          </div>
        </div>
      </div>

      <!-- 中间 -->
      <div class="col-md-4 col-sm-6 hidden-xs p0">
        <div class="container-fluid">
          <div class="row list">
              <?php if($hotMusic): if(is_array($hotMusic)): foreach($hotMusic as $key=>$v): ?><div class="col-md-12">
                      <span>
                        <a href="#"><?php echo ($v["musicname"]); ?></a>
                        <strong>－</strong>
                        <a href="#"><?php echo ($v["author"]); ?></a>
                      </span>
                      <i class="glyphicon glyphicon-plus-sign"></i>
                      <i class="visible-xs-block">
                        <a href="#" class="glyphicon glyphicon-play-circle"></a>
                      </i>
                      <i class="glyphicon glyphicon-play-circle hidden-xs" mid='<?php echo ($v["id"]); ?>'></i>
                </div><?php endforeach; endif; endif; ?>
          </div>
        </div>
      </div>

      <!-- 右侧 -->
      <div class="col-md-4 col-sm-6 hidden-xs  hidden-sm p0">
        <div class="container-fluid">
          <div class="row list">
              <?php if($oldMusic): if(is_array($oldMusic)): foreach($oldMusic as $key=>$v): ?><div class="col-md-12">
                      <span>
                        <a href="#"><?php echo ($v["musicname"]); ?></a>
                        <strong>－</strong>
                        <a href="#"><?php echo ($v["author"]); ?></a>
                      </span>
                      <i class="glyphicon glyphicon-plus-sign"></i>
                      <i class="visible-xs-block">
                        <a href="#" class="glyphicon glyphicon-play-circle"></a>
                      </i>
                      <i class="glyphicon glyphicon-play-circle hidden-xs" mid='<?php echo ($v["id"]); ?>'></i>
                </div><?php endforeach; endif; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>






  
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


  <!-- 自己的js -->
  <script type="text/javascript" src="/Public/js/Index/index.js"></script>

</body>
</html>