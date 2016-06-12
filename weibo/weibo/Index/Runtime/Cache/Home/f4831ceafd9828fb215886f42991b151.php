<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>我的首页</title>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/Uploadify/uploadify.css">
  <link rel="stylesheet" type="text/css" href="/weibo/Public/zoom/zoom.css">
  <script type="text/javascript" src="/weibo/Public/js/j.js"></script>
  <script type="text/javascript" src="/weibo/Public/js/Tool.js"></script>
  <script type="text/javascript" src="/weibo/Public/Uploadify/jquery.uploadify.min.js"></script>
  <script type="text/javascript">
    var addGroupUrl    = "<?php echo U('Common/addGroup');?>";//点击 分组AJAX处理
    var CommentUrl     = "<?php echo U('Comment');?>";//ajax 评论处理
    var CommentListUrl = "<?php echo U('getComentAll');?>";//ajax后台取来评论列表
    var praiseAjaxUrl  = "<?php echo U('praiseAjax');?>";//点赞后 AJAX后台更新
    var getGidUrl      = "<?php echo U('getGid');?>";//切换组 的ajax提交处理地址
    var keepUrl        = "<?php echo U('keep');?>";//AJAX收藏处理URl
    var unKeepUrl      = "<?php echo U('unKeep');?>";//取消收藏URl
    var deleteatUrl    = "<?php echo U('deleteat');?>";//删除@的文章
  </script>
  <script type="text/javascript" src="/weibo/Public/js/keepList.js"></script>
</head>
<body>
  <!-- 头部模板 -->
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
        <li><a href="#">私信</a></li>
        <li><a href="#">评论</a></li>
        <li><a href="#">@我</a></li>
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
    <img src="/weibo/Public/images/style9.jpg" alt="style9">
    <input type="hidden" name="changeBgStyle">
    <div class="changeClick">
      <p class="sendc">保存</p>
      <p class="x">取消</p>
    </div>
  </div>

   <link rel="stylesheet" type="text/css" href="/weibo/Public/Theme/<?php echo ($style); ?>/css/self.css">
  <div id="main">
    <div id="sdebar">
      <ul class="top">
        <li><i class="icon-home"></i><a href="<?php echo U('Self/index');?>">首页</a></li>
        <li><i class="icon-mention"></i><a href="<?php echo U('Self/atmeList');?>">提到我的</a></li>
        <li><i class="icon-comments"></i><a href="<?php echo U('Self/commentList');?>">评论</a></li>
        <li><i class="icon-chat3"></i><a href="<?php echo U('Self/callMeList');?>">私信</a></li>
        <li><i class="icon-star-empty"></i><a href="<?php echo U('keepList');?>">收藏</a></li>
      </ul>
      <h1>分组</h1>
      <ul class="bottom" id="ulBottom">
        <input type="hidden" name="nowGroup" value="">
        <li><i class="icon-user-tie"></i><a href="<?php echo U('Self/index');?>" gid="0">全部</a></li>
<?php if(is_array($group)): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li><i class="icon-user-tie"></i><a href="<?php echo U('Self/index');?>" gid="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
      <a href="" id="addGroupAjax">创建新分组</a>
      <input type="text" id="addGroupText">
      <i class="icon-plus2" id="icon-plus2"></i>
      <span id="Groupmsg">该分组已经存在</span>
    </div>
    <div id="mainRBox">
      <div id="mainWB">
<!--                          博客发表和博客转发                            -->
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
              <?php if($type): ?><a href="#" class="deleteat" wid=<?php echo ($vo["id"]); ?>>清除消息</a><?php endif; ?>
              <?php if(!$type): ?><a href="#" class="keepTime">收藏于:　<?php echo (date('Y-m-d H:i:s',$vo['ktime'])); ?></a><?php endif; ?>
            </h4>
           <div class="timeIFM"><i class="icon-clock"> 
                  <?php echo ($vo["timeStr"]); ?>
           <span class="hiddenTime"><?php echo ($vo["time"]); ?></span></i>　　来自可以防弹的手机</div>
          </header>
          <p class="blogContent">
            <?php echo (replace_weibo($vo["content"])); ?>
          </p>
          <div class="userUploadImg">
<?php if($vo['max']): ?><img src="/weibo<?php echo ($vo["max"]); ?>" data-action="zoom"><?php endif; ?>
          </div>
          <footer>
            <ul class="operation">
              <li><a href="#" wid="<?php echo ($vo["id"]); ?>" class="keep"><i class="<?php if($vo['kid']): ?>icon-star-full<?php else: ?>icon-star-empty<?php endif; ?>">　<span><?php if($type): ?>收藏<?php else: ?>已收藏<?php endif; ?></span></i></a></li>
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
<?php if($userinfo['face']): ?>/weibo<?php echo ($userinfo['face']); ?>
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
              <?php if($type): ?><a href="#" class="deleteat" wid=<?php echo ($vo["id"]); ?>>清除消息</a><?php endif; ?>
              <?php if(!$type): ?><a href="#" class="keepTime">收藏于:　<?php echo (date('Y-m-d H:i:s',$vo['ktime'])); ?></a><?php endif; ?>
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
<?php if($vo['isturn']['max']): ?><img src="/weibo<?php echo ($vo["isturn"]["max"]); ?>" data-action="zoom"><?php endif; ?>
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
              <li><a href="#" wid="<?php echo ($vo["id"]); ?>" class="keep"><i class="<?php if($vo['kid']): ?>icon-star-full<?php else: ?>icon-star-empty<?php endif; ?>">　<span><?php if($type): ?>收藏<?php else: ?>已收藏<?php endif; ?></span></i></a></li>
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
<?php if($userinfo['face']): ?>/weibo<?php echo ($userinfo['face']); ?>
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
<?php else: ?>
  <span id="notWB"><?php if($type): ?>您暂时没有被@过~<?php else: ?>您暂时没有收藏的内容~<?php endif; ?></span><?php endif; ?>     <!-- 是否存在数据结束 -->
<?php if($page): ?><div class="pages"><?php echo ($page); ?></div><?php endif; ?>
  </ul>
    </div>
<!-- 整体微博结束 -->
      </div>
      <div id="userSet">
       <div class="userIFM" value='<?php echo ($userinfo["uid"]); ?>'>
         <div class="bg">
           <img src="/weibo/Public/images/self_set.jpg">
           <a href="<?php echo U('UserSetting/index');?>/type/face" target="_blank"><img src="
<?php if($userinfo['face']): ?>/weibo<?php echo ($userinfo["face"]); ?>
  <?php else: ?>
            /weibo/Public/images/none.png<?php endif; ?>
        "></a>
         </div>
         <span><a target="_blank" href="<?php echo U('UserSetting/index');?>" class="username"><?php echo ($userinfo["username"]); ?></a></span>
         <div class="ul">
           <ul>
             <li><a href="<?php echo U('/follow/'.$userinfo["uid"]);?>"><p><?php echo ($userinfo["follow"]); ?></p><span>关注</span></a></li>
             <li><a href="<?php echo U('/fans/'.$userinfo["uid"]);?>"><p><?php echo ($userinfo["fans"]); ?></p><span>粉丝</span></a></li>
             <li><a href="#"><p class="userWeibo"><?php echo ($userinfo["weibo"]); ?></p><span>微博</span></a></li>
           </ul>
         </div>
       </div>


            <!-- 可能感兴趣的人 -->
          <?php if($resultI): ?><div id="interest">
            <span>可能感兴趣的人<a href="#">更多</a></span>
              <?php if(is_array($resultI)): $i = 0; $__LIST__ = $resultI;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="interestLi">
                <a href="<?php echo U('/'.$vo['uid']);?>" class="img">
                  <img src="
<?php if($vo['face']): ?>/weibo<?php echo ($vo["face"]); ?>
  <?php else: ?>
                  /weibo/Public/images/none.png<?php endif; ?>
                  ">
                </a>
                <span class="name"><a href="<?php echo U('/'.$vo['uid']);?>"><?php echo ($vo["username"]); ?></a>
                <i class="<?php if($vo['sex']!='男'): ?>icon-male<?php else: ?>icon-female<?php endif; ?>" style="color:
<?php if($vo['sex']!='男'): ?>#F18CAE
<?php else: ?>
          #80D2F0<?php endif; ?>
                "></i>
                </span>
                <span class="location"><?php echo ($vo["location"]); ?><font><strong> <?php echo ($vo["count"]); ?> </strong>个共同好友</font></span>
              </div><?php endforeach; endif; else: echo "" ;endif; ?>
          </div><?php endif; ?>
            <!-- 热门话题 -->
        <?php if(hotwb): ?><div class="hotTopic">
            <h1>热门话题</h1>
            <ul>
              <?php if(is_array($hotwb)): foreach($hotwb as $key=>$vo): ?><li><a href="<?php echo U('Discuss/index',array('wid'=>$vo['id']));?>"><?php echo (omitString($vo["content"],12)); ?></a><span><?php echo ($vo["comment"]); ?></span></li><?php endforeach; endif; ?>
            </ul>
          </div><?php endif; ?>
      </div>
    </div>
  </div>
  <div id="fade"><span></span></div>
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
  <a href="#mainRBox" id="return"><i class="icon-rocket"></i></a>
</body>
</html>
<script type="text/javascript" src="/weibo/Public/zoom/zoom.js"></script>
<script type="text/javascript" src="/weibo/Public/zoom/bootstrap.min.js"></script>