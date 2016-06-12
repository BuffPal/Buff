<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>所有评论</title>
  <script type="text/javascript" src="/weibo/Public/js/j.js"></script>
  <script type="text/javascript">
    var CommentUrl = "<?php echo U('Self/Comment');?>";
    var praiseAjaxUrl = "<?php echo U('Self/praiseAjax');?>";
  </script>
  <script type="text/javascript" src="/weibo/Public/js/Tool.js "></script>
  <script type="text/javascript" src="/weibo/Public/js/discuss.js"></script>
</head>
<body>
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

  <link rel="stylesheet" type="text/css" href="/weibo/Public/Theme/<?php echo ($style); ?>/css/discuss.css">
  <div class="mainBox">
    <div id="main">
    <?php if(!$data['isturn']): ?><article>
        <header>
          <a href="<?php echo U('/'.$data['uid']);?>" class="userFace"><img src="
          <?php if($data['face']): ?>/weibo<?php echo ($data["face"]); ?>
          <?php else: ?>
            /weibo/Public/images/none.png<?php endif; ?>
          "></a>
          <span class="username" userid="<?php echo ($data['uid']); ?>"><a href="<?php echo U('/'.$data['uid']);?>"><?php echo ($data['username']); ?></a></span>
          <a class="time"><?php echo (date('Y-m-d H:i:s',$data['time'])); ?>　　来自可以防弹的手机</a>
        </header>
        <p class="content">
          <?php echo (replace_weibo($data['content'])); ?> 
        </p>
        <!-- 判断有没有配图 -->
        <?php if($data['medium']): ?><div class="picture">
          <img src="/weibo<?php echo ($data["max"]); ?>">
        </div><?php endif; ?>
        <footer>
          <ul>
            <li><a href="#"><i class="icon-star-empty"></i>　收藏</a></li>
            <li><a href="#" class="operation" alt="<?php echo ($data["id"]); ?>" id="<?php echo ($data["id"]); ?>"><i class="icon-redo2"></i>　<span><?php echo ($data["turn"]); ?></span></a></li>
            <li><a href="#" class="praiseE" wid=<?php echo ($data["id"]); ?>><i class="icon-fire"></i>　<span><?php echo ($data["praise"]); ?></span></a></li>
            <li><a href="#" class="commentE"><i class="icon-chat"></i>　<span><?php echo ($data["comment"]); ?></span></a></li>
          </ul>
        </footer>
        <!-- 评论 -->
        <div class="comment">
          <div class="publish">
            <div class="input">
              <img src="
              <?php if($self['face']): ?>/weibo<?php echo ($self["face"]); ?>
              <?php else: ?>
                /weibo/Public/images/none.png<?php endif; ?>
              ">
              <input type="text" name="comment" id="<?php echo ($wid); ?>" sign="phiz<?php echo ($data["id"]); ?>">
            </div>
            <div class="phiz">
              <i class="icon-smile" id="icon-smileComment" name='reply' sign="phiz<?php echo ($data["id"]); ?>"> </i>
              <span class="commentE">评论</span>
            </div>
          </div>
          <div class="list_ul">
            <?php if($list): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!-- 分页数据循环 -->
                <div class="list_li">
                  <a href="<?php echo U('/'.$vo['uid']);?>" class="userFace">
                    <img src="
                    <?php if($vo['face']): ?>/weibo<?php echo ($vo["face"]); ?>
                    <?php else: ?>
                      /weibo/Public/images/none.png<?php endif; ?>
                    ">
                  </a>
                  <div class="text"><a href="'.U('/'.$vo['uid']).'"><?php echo ($vo["username"]); ?></a> :  <?php echo (replace_weibo($vo["content"])); ?></div>
                  <div class="time">
                    <span class="timeStr"><?php echo ($vo["timeStr"]); ?>　<p><?php echo ($vo["time"]); ?></p></span>
                    <span class="support"><p class="supportClick">回复</p>　　赞&nbsp<strong>804</strong></span>
                  </div>
                  <div class="reply">
                    <input type="text" name="reply" class="reply">
                    <span class="replyByReply">
                      <i class="icon-smile"></i>
                      <span>评论</span>
                    </span>
                  </div>
                </div>
              <!-- 分页循环结束 --><?php endforeach; endif; else: echo "" ;endif; endif; ?>
          </div>
            <div class="pages"><?php echo ($page); ?></div>
          </div>
            <div class="moreReply"><a href="<?php echo U('Discuss/index',array('wid'=>$data['id']));?>"></a></div>
<!-- 评论结束/ -->
      </article>
<?php else: ?>
      <!-- 转发样式 -->
       <article>
        <header>

          <a href="<?php echo U('/'.$data['uid']);?>" class="userFace"><img src="
          <?php if($data['face']): ?>/weibo<?php echo ($data["face"]); ?>
          <?php else: ?>
            /weibo/Public/images/none.png<?php endif; ?>
          "></a>
          <span class="username" userid="<?php echo ($data['uid']); ?>"><a href="<?php echo U('/'.$data['uid']);?>"><?php echo ($data['username']); ?></a></span>
          <a class="time"><?php echo (date('Y-m-d H:i:s',$data['time'])); ?>　　来自可以防弹的手机</a>
        </header>
        <p class="content">
          <?php echo (replace_weibo($data['content'])); ?> 
        </p>
        <!-- 判断有没有配图 -->
        <div class="userforwarding">
          <h4 class="userIFM">
              <a href="<?php echo U('/' . $data['isturn']['uid']);?>" class="userNameisturn" name="<?php echo ($data["isturn"]["uid"]); ?>" target="_blank"><?php echo ($data["isturn"]["username"]); ?></a>
              <a href="#" class="userLevel"><i class="icon-award8"></i></a>
          </h4>
          <p class="forwardingContent">
              <?php echo (replace_weibo($data["isturn"]["content"])); ?>
          </p>
           <div class="forwardingUploadImg">
<?php if($data['isturn']['max']): ?><img src="/weibo<?php echo ($data["isturn"]["medium"]); ?>"><?php endif; ?>
            </div>
            <div class="forwardingIFM">
              <span class="forwardingTime"><?php echo (date('Y-m-d H:i:s',$data["isturn"]["time"])); ?></span>
              <ul class="forwardingCount">
                <li><a href="#" class="operation" yid=<?php echo ($data["isturn"]["id"]); ?>><i class="icon-redo2"></i>　<span><?php echo ($data["isturn"]["turn"]); ?></span></a></li>
                <li><a href="#" class="praiseE" wid="<?php echo ($data["isturn"]["id"]); ?>"><i class="icon-fire"></i>　<span><?php echo ($data["isturn"]["praise"]); ?></span></a></li>
                <li><a href="#"><i class="icon-chat"></i>　<span><?php echo ($data["isturn"]["comment"]); ?></span></a></li>
              </ul>
            </div>
        </div>
        <footer>
          <ul>
            <li><a href="#"><i class="icon-star-empty"></i>　收藏</a></li>
            <li><a href="#" class="operation" id="<?php echo ($data["id"]); ?>" tid="<?php echo ($data["isturn"]["id"]); ?>"><i class="icon-redo2"></i>　<span><?php echo ($data["turn"]); ?></span></a></li>
            <li><a href="#" class="praiseE" wid="<?php echo ($data["id"]); ?>"><i class="icon-fire"></i>　<span><?php echo ($data["praise"]); ?></span></a></li>
            <li><a href="#" class="commentE"><i class="icon-chat"></i>　<span><?php echo ($data["comment"]); ?></span></a></li>
          </ul>
        </footer>
        <!-- 评论 -->
        <div class="comment">
          <div class="publish">
            <div class="input">
              <img src="
              <?php if($self['face']): ?>/weibo<?php echo ($self["face"]); ?>
              <?php else: ?>
                /weibo/Public/images/none.png<?php endif; ?>
              ">
              <input type="text" name="comment" id="<?php echo ($wid); ?>" sign="phiz<?php echo ($data["id"]); ?>">
            </div>
            <div class="phiz">
              <i class="icon-smile" id="icon-smileComment" name='reply' sign="phiz<?php echo ($data["id"]); ?>"> </i>
              <span class="commentE">评论</span>
            </div>
          </div>
          <div class="list_ul">
            <?php if($list): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!-- 分页数据循环 -->
                <div class="list_li">
                  <a href="<?php echo U('/'.$vo['uid']);?>" class="userFace">
                    <img src="
                    <?php if($vo['face']): ?>/weibo<?php echo ($vo["face"]); ?>
                    <?php else: ?>
                      /weibo/Public/images/none.png<?php endif; ?>
                    ">
                  </a>
                  <div class="text"><a href="'.U('/'.$vo['uid']).'"><?php echo ($vo["username"]); ?></a> :  <?php echo (replace_weibo($vo["content"])); ?></div>
                  <div class="time">
                    <span class="timeStr"><?php echo ($vo["timeStr"]); ?>　<p><?php echo ($vo["time"]); ?></p></span>
                    <span class="support"><p class="supportClick">回复</p>　　赞&nbsp<strong>804</strong></span>
                  </div>
                  <div class="reply">
                    <input type="text" name="reply" class="reply">
                    <span class="replyByReply">
                      <i class="icon-smile"></i>
                      <span>评论</span>
                    </span>
                  </div>
                </div>
              <!-- 分页循环结束 --><?php endforeach; endif; else: echo "" ;endif; endif; ?>
          </div>
            <div class="pages"><?php echo ($page); ?></div>
          </div>
            <div class="moreReply"><a href="<?php echo U('Discuss/index',array('wid'=>$data['id']));?>"></a></div>
<!-- 评论结束/ -->
      </article><?php endif; ?>
    </div>
    <div id="sidebar"></div>
  </div>
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
  <div id="fade"><span></span></div>
  <input type="hidden" name="sessionUid" value="<?php echo ($sessionUid); ?>">
</body>
</html>