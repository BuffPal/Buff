<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>微博找人</title>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/style.css">
  <script type="text/javascript" src="/weibo/Public/js/j.js"></script>
  <script type="text/javascript" src="/weibo/Public/js/Tool.js"></script>
   <script type="text/javascript">
    var addGroupUrl  = "<?php echo U('Common/addGroup');?>";
    var addFollowUrl = "<?php echo U('Common/addFollow');?>";
    var unFollowUrl  = "<?php echo U('Common/unFollow');?>";
  </script>
  <script type="text/javascript" src="/weibo/Public/js/search.js"></script>
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

  <link rel="stylesheet" type="text/css" href="/weibo/Public/Theme/<?php echo ($style); ?>/css/serch.css">
  <div id="main">
    <div id="top">
      <img src="/weibo/Public/images/baidulogo.png" id="LOGO">
      <span id="sosoren">
        <a href="<?php echo U('search');?>/keyword/<?php echo ($keyword); ?>" class="click">综合</a>
        <a href="<?php echo U('searchren');?>/keyword/<?php echo ($keyword); ?>">找人</a>
        <a href="#">图片</a>
        <a href="#">主页</a>
      </span>
    </div>
    <nav>
      <form action="" method="get"><input type="text" name="keyword" value="<?php echo ($keyword); ?>" id="keyword">
      <input type="submit" value="搜　索" id="keywordSend">
      </form>
      <span>
        <a href="#">高级搜索</a>
        <a href="#">设置</a>
        <a href="#">帮助</a>
      </span>
    </nav>
    <div id="news">
      <!-- 搜索出来排名最高的用户(粉丝量最高)只有一个 -->
<?php if($resultOne): ?><div class="getone">
          <a href="<?php echo U('/'.$resultOne['uid']);?>" class="img"><img src="
  <?php if($resultOne['face']): ?>/weibo<?php echo ($resultOne['face']); ?>
    <?php else: ?>
            /weibo/Public/images/none.png<?php endif; ?>
          "></a>
          <p class="star_name"><a href="<?php echo U('/'.$resultOne['uid']);?>"><?php echo ($resultOne["username"]); ?> </a><i class="icon-medal5"></i></p>
          <p class="star_card">
            <i class="<?php if($resultOne['sex']!='男'): ?>icon-male<?php else: ?>icon-female<?php endif; ?>" style="color: 
<?php if($resultOne['sex']!='男'): ?>#F18CAE
    <?php else: ?>
              #80D2F0<?php endif; ?>
            "></i> <?php echo ($resultOne["location"]); ?> <a href="">www.weibo.com</a></p>
          <p class="star_info"><?php echo ($resultOne["intro"]); ?></p>
          <p class="star_num">
            <span>关注<a href="#"> <?php echo ($resultOne["follow"]); ?></a></span>
            <span>　粉丝<a href="#" class="fansCount"> <?php echo ($resultOne["fans"]); ?></a></span>
            <span>　微博<a href="#"> <?php echo ($resultOne["weibo"]); ?></a></span>
          </p>
          <p class="newwb"><a href="">最新微博</a> : <a href="#" class="title">三分命中率报表</a></p>
          <input type="button" value="<?php if($resultOne['mutual']==2): ?>互相关注<?php elseif($resultOne['mutual'] == 1): ?>已关注<?php else: ?>关注<?php endif; ?>" class="
           <?php if($resultOne['mutual']!=0): ?>mutual<?php endif; ?>
         operation" uid='<?php echo ($resultOne["uid"]); ?>' status="<?php echo ($resultOne["mutual"]); ?>">
          <input type="hidden" name="LoginVerify" value="1">
        </div><?php endif; ?>
      <!-- /////搜索出来排名最高的用户(粉丝量最高)只有一个 -->
      <!-- 搜索出来的内容(标题或者内容这里不搜索用户名) -->
      <article class="sosoContent">
        <header><i class="icon-award7"></i>　30分钟前　转赞人数超过215万</header>
        <div class="content">
          <a href=""><img src="/weibo/Public/images/none.png" alt=""></a>
          <a href=""><p class="author">费斯图斯-埃泽利　<i class="icon-medal5"></i></p></a>
          <span class="info">勇士最大的原因就是失误…是不是光练三分和技巧了…团队之间的传球容易被断可能是因为小个阵容，最棒的是李文和巴博萨，稳定发挥几个小高潮经常的，关键球最好的是巴恩斯和汤汤，一哥和埃泽利刚回来还需要训练。库里体现的太重要就容易失衡，据库里的好胜心来说，他绝对会勤加训练，期待接下来全胜。</span>
          <ul>
            <li>
              <img src="/weibo/Public/images/4.jpg">
              <img src="/weibo/Public/images/4.jpg">
              <img src="/weibo/Public/images/4.jpg">
            </li>
            <span id="shuoming">2015年8月23日 来自 微博weibo.com</span>
          </ul>
        </div>
        <footer>
          <span>收藏</span>
          <span>转发　643</span>
          <span>评论　1258</span>
          <span><i class="icon-flame"></i>　597</span>
        </footer>
      </article>
      <!-- //////搜索出来的内容(标题或者内容这里不搜索用户名) -->
    </div>



    <div id="sidebar">
    <!-- 用户搜索相关用户 -->
      <div id="relatedUser">
        <span>相关用户<a href="<?php echo U('searchren');?>/keyword/<?php echo ($keyword); ?>">更多</a></span>
        <ul>
<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <a href="<?php echo U('/'.$vo['uid']);?>"><img src="
<?php if($vo['face']): ?>/weibo<?php echo ($vo['face']); ?>
  <?php else: ?>
          /weibo/Public/images/none.png<?php endif; ?>
          "></a>
            <span class="name"><a href="<?php echo U('/'.$vo['uid']);?>"><?php echo (str_replace($keyword,'<span style="color:orangered;">'.$keyword.'</span>',$vo["username"])); ?> </a> <i class="icon-medal5"></i></span>
            <span class="info"><?php echo (str_replace($keyword,'<span style="color:orangered;">'.$keyword.'</span>',omitString($vo["intro"],16))); ?></span>
          </li><?php endforeach; endif; else: echo "" ;endif; ?>       
        </ul>
      </div>
      <!-- ////用户搜索相关用户 -->
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
  <!-- 隐藏框框 -->
<!-- ============================隐藏转发输入框  复制过来的========================== -->
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
          还没有分组?<a href="#" class="addGroup">点击添加</a>
          <input type="text" name="add" id="addText">
          <span id="addGroupBtn">添加</span>
        </span>
        <input type="hidden" name="follow" value="">
        <input type="button" value="取消" class="icon-cross">
        <input type="submit" value="关注" name="btn" id="addFollowBtn">
      </div>
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
</body>
</html>