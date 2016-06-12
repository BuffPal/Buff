<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>个人微博</title>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/style.css">
  <link rel="stylesheet" type="text/css" href="/weibo/Public/zoom/zoom.css">
  <link rel="stylesheet" type="text/css" href="/weibo/Public/Uploadify/uploadify.css">
  <script type="text/javascript" src="/weibo/Public/js/j.js"></script>
  <script type="text/javascript">
    var praiseAjaxUrl  = "<?php echo U('Self/praiseAjax');?>";//点赞后 AJAX后台更新
    var CommentUrl     = "<?php echo U('Self/Comment');?>";//ajax 评论处理
    var CommentListUrl = "<?php echo U('Self/getComentAll');?>";//ajax后台取来评论列表
    var LoginUrl = "<?php echo U('Login/index');?>";//登陆页面跳转地址
    var addFollowUrl = "<?php echo U('Common/addFollow');?>";//添加关注
    var unFollow     = "<?php echo U('Common/unFollow');?>";//取消关注
    var addGroupUrl  = "<?php echo U('Common/addGroup');?>";//添加组
  </script>
  <script type="text/javascript" src="/weibo/Public/js/Tool.js"></script>
  <script type="text/javascript" src="/weibo/Public/js/header.js"></script>
  <script type="text/javascript" src="/weibo/Public/js/index.js"></script>
</head>
<body>
<!-- ============================header include 用========================== -->
    <link rel="stylesheet" type="text/css" href="/weibo/Public/css/header.css">
  <link rel="stylesheet" type="text/css" href="/weibo/Public/style.css">
  <script type="text/javascript">
    var changeBgUrl = "<?php echo U('Self/changebg');?>"; 
  </script>
  <script type="text/javascript" src="/weibo/Public/js/header.js"></script>
  <input type="hidden" name="session" value="<?php echo session('uid');?>">
  <div id="header">
    <nav>
      <a class="logo" href="#">
        首页
        <img src="/weibo/Public/images/baidulogo.png" alt="首页" class="logo">
      </a>
      <ul>
        <li><a href="<?php echo U('Self/index');?>">首页</a></li>
        <li><a href="<?php echo U('Self/callMeList');?>">私信</a></li>
        <li><a href="<?php echo U('Self/commentList');?>">评论</a></li>
        <li><a href="<?php echo U('Self/atmeList');?>">@我</a></li>
        <li><form action="<?php echo U('Search/search');?>" method="get"><input type="text" name="keyword" id="soso" placeholder="<?php echo ($hotsoso); ?>"><input type="submit" value="搜　索" id="sosoBtn"></form></li>
        <li><a href="<?php echo U('Index/index');?>">主页</a></li>
        <li><a href="#"><i class="icon-checklist"></i></a></li>
        <li><a href="#"><i class="icon-mail5"></i></a></li>
        <li><a href="#"><i class="icon-book2"></i></a>
           <ul class="hidden10">
              <li><a href="<?php echo U('UserSetting/index');?>">账号设置</a></li>
              <li><a href="#" class="changeBgA">模板设置</a></li>
              <li><a href="<?php echo U('Self/logout');?>">退出登录</a></li>
           </ul>
        </li>
        <li><a href="#"><i class="icon-radio-checked"></i></a></li>
      </ul>
    </nav>
  </div>
  <div id="hiddenOperationBox">
    <div class="content">
      <div class="moverHidOper"><i class="icon-cross" name="icon-cross"></i></div>
      <h1><span>转发微博</span></h1>
      <a target="_blank" href="" id="operationUsername"></a><span id="operationSpan"></span>
      <p class="inputCount">还可以输入[ <span id="font-numo"> 140 </span> ]个字</p>
      <form action="<?php echo ($operationWeibo); ?>" method="post">
        <input type="hidden" name="wid" value="">
        <input type="hidden" name="tid" value="0">
        <textarea name="operationContento"></textarea>
        <div class="footer">
          <i class="icon-smile" id="icon-smileOperation"> <!-- 头像隐藏框 -->
          </i>
          <span id="isturnIFM"></span>
        <input type="submit" value="转发" name="btn" id="operationFromSbt"></div>
      </form>
    </div>
  </div>
  <div id="fade"><span></span></div>
  <?php $style = M('userinfo')->where(array('uid'=>session('uid')))->getField('style'); ?>
  <div id="changebgBox">
    <h1 id="changebgMove">请选择您要更换的背景</h1>
    <img src="/weibo/Public/images/style1.jpg" alt="style1">
    <img src="/weibo/Public/images/style2.jpg" alt="style2">
    <img src="/weibo/Public/images/style3.jpg" alt="style3">
    <img src="/weibo/Public/images/style4.jpg" alt="style4">
    <img src="/weibo/Public/images/style5.jpg" alt="style5">
    <img src="/weibo/Public/images/style6.jpg" alt="style6">
    <img src="/weibo/Public/images/style7.jpg" alt="style7">
    <img src="/weibo/Public/images/style8.jpg" alt="style8">
    <img src="/weibo/Public/images/style9.jpg" alt="default">
    <input type="hidden" name="changeBgStyle">
    <div class="changeClick">
      <p class="sendc">保存</p>
      <p class="x">取消</p>
    </div>
  </div>

  <link rel="stylesheet" type="text/css" href="/weibo/Public/Theme/<?php echo ($style); ?>/css/index.css">
  <div id="main">
  <!-- ============================用户头部========================== -->
    <div class="header">
      <div class="userInfo">
        <div class="userPic">
          <img src="/weibo/Public/images/user_bg.jpg" class="userBg">
          <a href="#"><img src="
          <?php if($userinfo['face']): ?>/weibo<?php echo ($userinfo["face"]); ?>
          <?php else: ?>
            /weibo/Public/images/none.png<?php endif; ?>
          " class="userHeaderPic"></a>
          <a href="#"><h1 class="userName"><?php echo ($userinfo["username"]); ?></h1></a>
          <a href="#"><span>
          <?php if($userinfo['intro']): echo ($userinfo["intro"]); ?>
          <?php else: ?>
            点击修改您的个人介绍~<?php endif; ?>
          </span></a>
          <input type="button" value="<?php if($userinfo['mutual'] == 0): ?>+关注<?php elseif($userinfo['mutual'] == 2): ?>互相关注<?php else: ?>已关注<?php endif; ?>" class="btn <?php if($userinfo['mutual'] != 0): ?>selected<?php endif; ?>" mutual="<?php echo ($userinfo["mutual"]); ?>" uid="<?php echo ($userinfo["uid"]); ?>">
        </div>
        <div class="society">
          <div class="fans">
            <span class="fansCount">粉丝列表</span>
            <ul class="fansSmallInfo">
              <?php if(is_array($fansData)): foreach($fansData as $key=>$vo): ?><li>
                <a href="<?php echo U('/' . $vo['uid']);?>"><img src="<?php if($vo['face']): ?>/weibo<?php echo ($vo['face']); else: ?>/weibo/Public/images/none.png<?php endif; ?>"></a>
                  <span><a href=""><?php echo ($vo["username"]); ?></a></span>
                </li><?php endforeach; endif; ?>
            </ul>
          </div>
          <div class="newRelease">
            <a href="#">最新动态</a>
            <?php if($newsCount >= 4): ?><div class="newReleasePage">
                <a href="#" value="-1">
                  <i class="icon-circle-right"></i>
                </a>
                
                <a href="#" value="1">
                  <i class="icon-circle-left"></i>
                </a>
              </div><?php endif; ?>
          </div>
          <div class="newReleaseInfo">
            <ul class="thumbnail" style="left: -2px;">
              <?php if($news): if(is_array($news)): foreach($news as $key=>$vo): ?><li>
                    <a href="<?php echo U('/discuss/'.$vo['wid']);?>" class="thumbnail" target="_blank"><img src="/weibo<?php echo ($vo["mini"]); ?>" alt="" ></a>
                    <div class="thumbnailInfo">
                      <a href="<?php echo U('/discuss/'.$vo['wid']);?>" class="thumbnailInfo" target="_blank"><?php echo (replace_weibo($vo["content"],false)); ?></a>
                    </div>
                  </li><?php endforeach; endif; endif; ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="userNav">
          <ul>
            <li><a href="" class="click">他的首页</a></li>
            <li><a href="">他的相册</a></li>
            <li><a href="">他的作品</a></li>
          </ul>
      </div>
    </div>
     <!-- ============================用户微博========================== -->
    <input type="hidden" name="LoginVerify" value="1">
    <div id="mainWB">
     <div class="blog">
      <ul id="blogUl">
<?php if($resultAll): if(is_array($resultAll)): $i = 0; $__LIST__ = $resultAll;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!-- 微博循环 -->
<?php if(!$vo["isturn"]): ?><!-- 判断是否是转发微博 -->
        <li>
        <a href="<?php echo U('/'.$vo['uid']);?>" class="blogUserPica"><img src="
<?php if($vo['face']): ?>/weibo<?php echo ($vo['face']); ?>
  <?php else: ?>
          /weibo/Public/images/none.png<?php endif; ?>
        " class="blogUserPic"></a>
         <article class="excerpt">
          <header>
            <h4 class="userIFM" value="<?php echo ($vo['uid']); ?>">
              <a href="<?php echo U('/'.$vo['uid']);?>" class="userName"><?php echo ($vo["username"]); ?></a>
              <a href="#" class="userLevel"><i class="icon-award8"></i></a>
            </h4>
           <div class="timeIFM"><i class="icon-clock"> 
                  <?php echo ($vo["timeStr"]); ?>
           <span class="hiddenTime"><?php echo ($vo["time"]); ?></span></i>　　来自可以防弹的手机</div>
          </header>
          <p class="blogContent">
            <?php echo (replace_weibo($vo["content"])); ?>
          </p>
          <div class="userUploadImg">
<?php if($vo['mini']): ?><img src="/weibo<?php echo ($vo["max"]); ?>" data-action="zoom"><?php endif; ?>
          </div>
          <footer>
            <ul class="operation">
              <li><a href="#" wid="<?php echo ($vo["id"]); ?>" class="keep"><i class="icon-star-empty">　<span>收藏</span></i></a></li>
              <li><a href="#" class="operation" alt="<?php echo ($vo["id"]); ?>" id="<?php echo ($vo["id"]); ?>"><i class="icon-redo2">　<span><?php echo ($vo["turn"]); ?></span></i></a></li>
              <li><a href="#" class="praiseE" wid="<?php echo ($vo['id']); ?>"><i class="icon-fire">　<span><?php echo ($vo["praise"]); ?></span></i></a></li>
              <li><a href="#" class="commentE" wid="<?php echo ($vo['id']); ?>"><i class="icon-chat">　<span><?php echo ($vo["comment"]); ?></span></i></a></li>
            </ul>
          </footer>
         </article>
<!-- 评论 -->
        <div class="comment">
          <div class="publish">
            <div class="input">
              <img src="
<?php if($userUid['face']): ?>/weibo<?php echo ($userUid['face']); ?>
  <?php else: ?>
          /weibo/Public/images/none.png<?php endif; ?>
              ">
              <input type="text" name="comment" id="<?php echo ($vo["id"]); ?>" sign="phiz<?php echo ($vo["id"]); ?>">
            </div>
            <div class="phiz">
              <i class="icon-smile" id="icon-smileComment" name='reply' sign="phiz<?php echo ($vo["id"]); ?>"> </i>
              <span class="commentE">评论</span>
            </div>
          </div>
          <div class="animate"><i class="icon-spinner6"></i></div>
          <div class="list_ul">
  <!-- 用户评论 -->      
  <!-- /用户评论 -->
          </div>
          <div class="moreReply"><a href="<?php echo U('Discuss/index',array('wid'=>$vo['id']));?>" target="_blank"></a></div>
        </div>
<!-- 评论结束/ -->
        </li>
<?php else: ?><!-- 是转发的循环转发样式 -->

<!-- ============================转发微博========================== -->
        <li class="forwarding">
        <a href="<?php echo U('/'.$vo['uid']);?>" class="blogUserPica" target="_blank"><img src="
<?php if($vo['face']): ?>/weibo<?php echo ($vo['face']); ?>
  <?php else: ?>
          /weibo/Public/images/none.png<?php endif; ?>
        " class="blogUserPic"></a>
         <article class="excerpt">
          <header>
            <h4 class="userIFM" value="<?php echo ($vo['uid']); ?>">
              <a href="<?php echo U('/'.$vo['uid']);?>" class="userName"  target="_blank"><?php echo ($vo["username"]); ?></a>
              <a href="#" class="userLevel"><i class="icon-award8"></i></a>
            </h4>
           <div class="timeIFM"><i class="icon-clock"> <?php echo ($vo["timeStr"]); ?><span class="hiddenTime"><?php echo ($vo["time"]); ?></span></i>　　来自可以防弹的手机</div>
          </header>
          <p class="blogContent">
            <?php echo (replace_weibo(str_replace('//','<span  style="color: #bbb;font-size: 12px;font-weight: bold;">//</span >',$vo["content"]))); ?>
          </p>

<?php if($vo['isturn'] == -1): ?><span class="deleteNotWb">用户转发的微博已被删除~</span>
<?php else: ?>
          <div class="userforwarding">
            <h4 class="userIFM">
              <a href="<?php echo U('/' . $vo['isturn']['uid']);?>" class="userNameisturn" name="<?php echo ($vo["isturn"]["uid"]); ?>" target="_blank"><?php echo ($vo["isturn"]["username"]); ?></a>
              <a href="#" class="userLevel"><i class="icon-award8"></i></a>
            </h4>
            <p class="forwardingContent">
              <?php echo (replace_weibo($vo["isturn"]["content"])); ?>
            </p>
            <div class="forwardingUploadImg">
<?php if($vo['isturn']['max']): ?><img src="/weibo<?php echo ($vo["isturn"]["max"]); ?>"  data-action="zoom"><?php endif; ?>
            </div>
            <div class="forwardingIFM">
              <span class="forwardingTime"><?php echo (date('Y-m-d H:i:s',$vo["isturn"]["time"])); ?></span>
              <ul class="forwardingCount">
                <li><a href="#" class="operation" yid=<?php echo ($vo["isturn"]["id"]); ?>><i class="icon-redo2"></i>　<span><?php echo ($vo["isturn"]["turn"]); ?></span></a></li>
                <li><a href="#" class="praise"><i class="icon-fire"></i>　<span><?php echo ($vo["isturn"]["praise"]); ?></span></a></li>
                <li><a href="#"><i class="icon-chat"></i>　<span><?php echo ($vo["isturn"]["comment"]); ?></span></a></li>
              </ul>
            </div>
          </div><?php endif; ?>
          <footer>
            <ul class="operation">
              <li><a href="#" wid="<?php echo ($vo["id"]); ?>" class="keep"><i class="icon-star-empty">　收藏</i></a></li>
              <li><a href="#" class="operation" id="<?php echo ($vo["id"]); ?>" tid="<?php echo ($vo["isturn"]["id"]); ?>"><i class="icon-redo2">　<span><?php echo ($vo["turn"]); ?></span></i></a></li>
              <li><a href="#" class="praiseE" wid="<?php echo ($vo["id"]); ?>"><i class="icon-fire">　<span><?php echo ($vo["praise"]); ?></span></i></a></li>
              <li><a href="#" class="commentE" wid="<?php echo ($vo['id']); ?>"><i class="icon-chat">　<span><?php echo ($vo["comment"]); ?></span></i></a></li>
            </ul>
          </footer>
         </article>
<!-- 评论 -->
        <div class="comment">
          <div class="publish">
            <div class="input">
              <img src="        
<?php if($userUid['face']): ?>/weibo<?php echo ($userUid['face']); ?>
  <?php else: ?>
          /weibo/Public/images/none.png<?php endif; ?>
          ">
          <input type="text" name="comment" id="<?php echo ($vo["id"]); ?>" sign="phiz<?php echo ($vo["id"]); ?>">
            </div>
            <div class="phiz">
              <i class="icon-smile" id="icon-smileComment" name='reply' sign="phiz<?php echo ($vo["id"]); ?>"> 
              </i>
              <span class="commentE">评论</span>
            </div>
          </div>
          <div class="animate"><i class="icon-spinner6"></i></div>
          <div class="list_ul">
  <!-- 用户评论 -->
  <!-- /用户评论 -->
          </div>
          <div class="moreReply"><a href="<?php echo U('Discuss/index',array('wid'=>$vo['id']));?>" target="_blank"></a></div>
        </div>
<!-- 评论结束/ -->
        </li><?php endif; ?><!-- 判断是否转发结束 --><?php endforeach; endif; else: echo "" ;endif; ?> <!-- 循环结束 -->
<div class="pages"><?php echo ($page); ?></div>
<?php else: ?>
  <span id="notWB">暂时没有内容~</span><?php endif; ?>     <!-- 是否存在数据结束 -->
      </ul>
</div>
</div>








   <div class="sidebar">
     <div class="fansnumber">
      <table border="0">
        <tr>
          <td><a href="#" style="border-left: none;"><strong><?php echo ($userinfo["follow"]); ?></strong><span>关注</span></a></td>
          <td><a href="#"><strong class="fansNum"><?php echo ($userinfo["fans"]); ?></strong><span>粉丝</span></a></td>
          <td><a href="#"><strong><?php echo ($userinfo["weibo"]); ?></strong><span>微博</span></a></td>
        </tr>
      </table>
     </div>

      <?php if($followData): ?><div id="followShow">
          <h1>他关注的人</h1>
          <ul id="followUl">
            <?php if(is_array($followData)): foreach($followData as $key=>$vo): ?><li>
                <a href="<?php echo U('/' . $vo['uid']);?>" class="img"><img src="<?php if($vo['face']): ?>/weibo<?php echo ($vo['face']); else: ?>/weibo/Public/images/none.png<?php endif; ?>"></a>
                <span class="username"><a href="<?php echo U('/' . $vo['uid']);?>"><?php echo ($vo["username"]); ?></a></span>
                <span class="follow"><p>关注: <strong><?php echo ($vo["follow"]); ?></strong></p><p>粉丝: <strong><?php echo ($vo["fans"]); ?></strong></p><p>微博: <strong><?php echo ($vo["weibo"]); ?></strong></p></span>
                <span class="newWB">最新微博:　<a href="<?php echo U('Discuss/index',array('wid'=>$vo['wid']));?>" target="_blank"><?php echo (replace_weibo($vo["content"],false)); ?></a></span>
              </li><?php endforeach; endif; ?>
          </ul>
        </div><?php endif; ?>



      <?php if(hotwb): ?><!-- 实时热搜榜(其实就是点击量) -->
        <div id="hotTime">
          <span>实时热搜榜<a href="#">更多</a></span>
          <ol>
            <?php if(is_array($hotwb)): foreach($hotwb as $key=>$vo): ?><li><b style="color: rgb(255,<?php echo ($key*20); ?>,<?php echo ($key*20); ?>)"><?php echo ($key+1); ?>.</b><span><?php echo ($vo["comment"]); ?></span><a href="<?php echo U('Discuss/index',array('wid'=>$vo['id']));?>"><?php echo (omitString($vo["content"],15)); ?></a></li><?php endforeach; endif; ?>
          </ol>
        </div>
        <!-- ////实时热搜榜(其实就是点击量) --><?php endif; ?>

   </div>
  </div>
  <!-- 尾部样式 -->
   <link rel="stylesheet" type="text/css" href="/weibo/Public/css/footer.css">
 <div id="footer">
  <div class="box">
      <ul>
        <li><a href="#">免责声明</a></li>
        <li><a href="#">友情链接</a></li>
        <li><a href="#">联系我们</a></li>
        <li><a href="#">关于我们</a></li>
      </ul>
      <span>www.localhsot.com</span>
      <ol>
        <li><i class="icon-sina-weibo"></i></li>
        <li><i class="icon-amazon"></i></li>
        <li><i class="icon-soundcloud"></i></li>
        <li><i class="icon-renren"></i></li>
      </ol>
    </div>
  </div>
  <div id="hiddenPhiz" name="hiddenPhizO" sign="">
            <i class="icon-cancel" name="x"></i>
            <img src="/weibo/Public/Images/phiz/hehe.gif" alt="呵呵" title="呵呵" />
            <img src="/weibo/Public/Images/phiz/xixi.gif" alt="嘻嘻" title="嘻嘻" />
            <img src="/weibo/Public/Images/phiz/haha.gif" alt="哈哈" title="哈哈" />
            <img src="/weibo/Public/Images/phiz/keai.gif" alt="可爱" title="可爱" />
            <img src="/weibo/Public/Images/phiz/kelian.gif" alt="可怜" title="可怜" />
            <img src="/weibo/Public/Images/phiz/wabisi.gif" alt="挖鼻屎" title="挖鼻屎" />
            <img src="/weibo/Public/Images/phiz/chijing.gif" alt="吃惊" title="吃惊" />
            <img src="/weibo/Public/Images/phiz/haixiu.gif" alt="害羞" title="害羞" />
            <img src="/weibo/Public/Images/phiz/jiyan.gif" alt="挤眼" title="挤眼" />
            <img src="/weibo/Public/Images/phiz/bizui.gif" alt="闭嘴" title="闭嘴" />
            <img src="/weibo/Public/Images/phiz/bishi.gif" alt="鄙视" title="鄙视" />
            <img src="/weibo/Public/Images/phiz/aini.gif" alt="爱你" title="爱你" />
            <img src="/weibo/Public/Images/phiz/lei.gif" alt="泪" title="泪" />
            <img src="/weibo/Public/Images/phiz/touxiao.gif" alt="偷笑" title="偷笑" />
            <img src="/weibo/Public/Images/phiz/qinqin.gif" alt="亲亲" title="亲亲" />
            <img src="/weibo/Public/Images/phiz/shengbin.gif" alt="生病" title="生病" />
            <img src="/weibo/Public/Images/phiz/taikaixin.gif" alt="太开心" title="太开心" />
            <img src="/weibo/Public/Images/phiz/ldln.gif" alt="懒得理你" title="懒得理你" />
            <img src="/weibo/Public/Images/phiz/youhenhen.gif" alt="右哼哼" title="右哼哼" />
            <img src="/weibo/Public/Images/phiz/zuohenhen.gif" alt="左哼哼" title="左哼哼" />
            <img src="/weibo/Public/Images/phiz/xiu.gif" alt="嘘" title="嘘" />
            <img src="/weibo/Public/Images/phiz/shuai.gif" alt="衰" title="衰" />
            <img src="/weibo/Public/Images/phiz/weiqu.gif" alt="委屈" title="委屈" />
            <img src="/weibo/Public/Images/phiz/tu.gif" alt="吐" title="吐" />
            <img src="/weibo/Public/Images/phiz/dahaqian.gif" alt="打哈欠" title="打哈欠" />
            <img src="/weibo/Public/Images/phiz/baobao.gif" alt="抱抱" title="抱抱" />
            <img src="/weibo/Public/Images/phiz/nu.gif" alt="怒" title="怒" />
            <img src="/weibo/Public/Images/phiz/yiwen.gif" alt="疑问" title="疑问" />
            <img src="/weibo/Public/Images/phiz/canzui.gif" alt="馋嘴" title="馋嘴" />
            <img src="/weibo/Public/Images/phiz/baibai.gif" alt="拜拜" title="拜拜" />
            <img src="/weibo/Public/Images/phiz/sikao.gif" alt="思考" title="思考" />
            <img src="/weibo/Public/Images/phiz/han.gif" alt="汗" title="汗" />
            <img src="/weibo/Public/Images/phiz/kun.gif" alt="困" title="困" />
            <img src="/weibo/Public/Images/phiz/shuijiao.gif" alt="睡觉" title="睡觉" />
            <img src="/weibo/Public/Images/phiz/qian.gif" alt="钱" title="钱" />
            <img src="/weibo/Public/Images/phiz/shiwang.gif" alt="失望" title="失望" />
            <img src="/weibo/Public/Images/phiz/ku.gif" alt="酷" title="酷" />
            <img src="/weibo/Public/Images/phiz/huaxin.gif" alt="花心" title="花心" />
            <img src="/weibo/Public/Images/phiz/heng.gif" alt="哼" title="哼" />
            <img src="/weibo/Public/Images/phiz/guzhang.gif" alt="鼓掌" title="鼓掌" />
            <img src="/weibo/Public/Images/phiz/yun.gif" alt="晕" title="晕" />
            <img src="/weibo/Public/Images/phiz/beishuang.gif" alt="悲伤" title="悲伤" />
            <img src="/weibo/Public/Images/phiz/zuakuang.gif" alt="抓狂" title="抓狂" />
            <img src="/weibo/Public/Images/phiz/heixian.gif" alt="黑线" title="黑线" />
            <img src="/weibo/Public/Images/phiz/yinxian.gif" alt="阴险" title="阴险" />
            <img src="/weibo/Public/Images/phiz/numa.gif" alt="怒骂" title="怒骂" />
            <img src="/weibo/Public/Images/phiz/xin.gif" alt="心" title="心" />
            <img src="/weibo/Public/Images/phiz/shuangxin.gif" alt="伤心" title="伤心" />
              </div>


  <!-- ============================添加用户分组 复制过来的========================== -->
<?php $group = M('group')->where(array('uid'=>session('uid')))->select(); ?>
  <div id="hiddenOperationBoxS">
    <div class="content">
      <div class="moverHidOper"></div>
      <h1><span>关注好友</span></h1>
      <div class="footer">
        <span class="select">
          <p>好友分组:　</p>
          <select name="night" id="group">
                <option selected="selected" value="0">默认分组</option>
<?php if(is_array($group)): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>

          </select>
          还没有分组?<a href="#" class="addGroup" style="color: #615CE3">点击添加</a>
          <input type="text" name="add" id="addText">
          <span id="addGroupBtn">添加</span>
        </span>
        <input type="hidden" name="follow" value="">
        <input type="button" value="取消" class="icon-cross">
        <input type="submit" value="关注" name="btn2" id="addFollowBtn">
      </div>
    </div>
  </div>
    <!-- 尾部样式 -->

</body>
</html>
<script type="text/javascript" src="/weibo/Public/zoom/zoom.js"></script>
<script type="text/javascript" src="/weibo/Public/zoom/bootstrap.min.js"></script>