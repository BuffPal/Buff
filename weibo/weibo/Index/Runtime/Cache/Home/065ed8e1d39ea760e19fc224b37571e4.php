<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>用户设置</title>
  <script type="text/javascript" src="/weibo/Public/js/j.js"></script>
    <script type="text/javascript">
    var type          = '<?php echo ($type); ?>';                     //用来判断用户是不是点击头像过来的
    var PUBLIC        = '/weibo/Public';
    var cityselectUrl = '/weibo/Public/js/city.min.js';//引入城市联动需要的json数据
    var constellation = '<?php echo ($userinfo["constellation"]); ?>';//获取用户默认星座
    var home          = '<?php echo ($userinfo["location"]); ?>';//获取用户默认地址
    var uploadFace    = "<?php echo U('Common/uploadFace');?>";//头像上传处理方法
    var ROOT          = '/weibo';
    var sid = '<?php echo session_id();?>';
     $(function(){
      $("#city").citySelect({
        nodata:"none",
        required:false
      }); 
    });
  </script>
  <script type="text/javascript" src="/weibo/Public/Uploadify/jquery.uploadify.min.js"></script>
  <script type="text/javascript" src="/weibo/Public/js/UserSetting.js"></script>
  <script type="text/javascript" src="/weibo/Public/js/jquery.cityselect.js"></script>
</head>
<body>
  <link rel="stylesheet" type="text/css" href="/weibo/Public/css/main.css">
  <link rel="stylesheet" type="text/css" href="/weibo/Public/css/UserSetting.css">
  <link rel="stylesheet" type="text/css" href="/weibo/Public/Uploadify/uploadify.css">
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

  <div id="main">
    <nav>
      <ul id="userNav">
        <li><a href="" class="click">基本信息</a></li>
        <li><a href="">修改头像</a></li>
        <li><a href="">修改密码</a></li>
      </ul>
    </nav>
    <table id="show1">
        <form action="<?php echo U('editBasic');?>" method="post">
          <input type="hidden" name="prev_url" value="<?php echo ($prev_url); ?>">
          <tr><th colspan="2">用户设置</th></tr>
          <tr><td><label for="username">　　昵称:</label></td><td><input type="text" id="username" class="text" name="username" value="<?php echo ($userinfo["username"]); ?>"></td></tr>
          <tr><td><label for="truename">真实姓名:</label></td><td><input type="text" id="truename" class="text" name="truename" value="<?php echo ($userinfo["truename"]); ?>"></td></tr>
          <tr><td colspan="2"><input type="radio" name="sex" value="男"<?php if($userinfo["sex"] == "男"): ?>checked="checked"<?php endif; ?> />男　<input type="radio" name="sex" value="女" <?php if($userinfo["sex"] == "女"): ?>checked="checked"<?php endif; ?> />女</td></tr>
          <tr><td colspan="2" id="province">
            <div id="city">所在地: 
              <select class="prov" name="province"></select>  
              <select class="city" disabled="disabled" name="city"></select> 
              <select class="dist" disabled="disabled" name="dist"></select>
            </div> 
          </td></tr>

          <tr><td><label for="constellation">　　星座:</label></td>
          <td><select name="night" id="constellation">
                <option value="">请选择</option>
                <option value="白羊座">白羊座</option>
                <option value="金牛座">金牛座</option>
                <option value="双子座">双子座</option>
                <option value="巨蟹座">巨蟹座</option>
                <option value="狮子座">狮子座</option>
                <option value="处女座">处女座</option>
                <option value="天枰座">天枰座</option>
                <option value="天蝎座">天蝎座</option>
                <option value="射手座">射手座</option>
                <option value="摩羯座">摩羯座</option>
                <option value="水瓶座">水瓶座</option>
                <option value="双鱼座">双鱼座</option>
              </select>
          </td></tr>
          <tr><td><label for="intro">介绍自己:</label></td><td><textarea id="intro" name="intro"><?php echo ($userinfo["intro"]); ?></textarea></td></tr>
          <tr><td colspan="2"><input type="submit" value="保存修改" class="sbt"></td></tr>
        </form>
      </table>
    <div class="userFace" id="show2" style="display: none;">
      <h1>修改头像</h1>
      <form action="<?php echo U('editFace');?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="prev_url" value="<?php echo ($prev_url); ?>">
        <input type="hidden" name="faceSql">
        <img src="

        <?php if($userinfo['face']): ?>/weibo<?php echo ($userinfo["face"]); ?>
        <?php else: ?>
          /weibo/Public/images/none.png<?php endif; ?>

        " id="userFace">
        <input type="file" name="face" id="face">
        <input type="submit" value="保存修改">
      </form>
    </div>
    <ol id="show3" style="display: none;">
      <form action="<?php echo U('editPwd');?>" method="post">
        <input type="hidden" name="prev_url" value="<?php echo ($prev_url); ?>">
        <li>修改密码</li>
        <li>登录邮箱:<span>localhost@qq.com</span></li>
        <li><label for="oldpassword">　旧密码:</label><input type="password" name="oldpassword" id="oldpassword" class="text"></li>
        <li><label for="newpassword">　新密码:</label><input type="password" name="newpassword" id="newpassword" class="text"></li>
        <li><label for="notpassword">确认密码:</label><input type="password" name="notpassword" id="notpassword" class="text"></li>
        <li><input type="submit" value="确认修改" class="sbt"></li>
      </form>
    </ol>
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