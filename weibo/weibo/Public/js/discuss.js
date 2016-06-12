$(function(){
 //回复回复评论点击 发送Ajax  第一个评论回复
 $("body").on('click','span.commentE',function(){
    var sContent = $(this).closest('div.phiz').siblings('div.input').children('input[name=comment]');
    var oUl      = $(this).closest('div.publish').siblings('div.list_ul');
    var oNum     = $(this).closest('div.comment').siblings('footer').find('a.commentE').find('span');//获取当前评论
    var iNum     = oNum.html();//获取当前评论用于AJAX成功后自增
    if($.trim(sContent.val()) == ''){
      flashingRed(sContent);//闪烁红光
      sContent.focus();
      return false;
    }else{
      $.post(CommentUrl,{
        'wid':sContent.attr('id'),
        'content':sContent.val()
      },function(data){
        if(data.status){
          tishi('评论成功~');
          sContent.val('');
          oUl.prepend(data.data);
          oNum.html(parseInt(iNum)+1);//该文章的 评论加1
        }else{
          alert(data.msg);
        }
      },'json');
    }
  })



//表情点击显示/隐藏
$("body").on('click','i.icon-smile',function(e){//所有的点击I标记 显示 表情选择框
  var x = $(this).position().left;
  var y = $(this).position().top;
  $('#hiddenPhiz').css({
    'top':y+30,
    'left':x
  });
  $('#hiddenPhiz').attr({
    'sign':$(this).attr('sign')
  });
  $('#hiddenPhiz').fadeIn();
 });


  //点赞 后台处理
  $("body").on('click','a.praiseE',function(){
    var wid = $(this).attr('wid');
    var Pcount = $(this).find('span');
    var iNum = Pcount.html();
    $.post(praiseAjaxUrl,{'wid':wid},function(data){
      if(data.status){//点赞成功
        Pcount.html(parseInt(iNum)+1);
        tishi('点赞成功~');
      }else{//点赞失败
        alert(data.msg);
      }
    },'json');
    return false;
  });

 //第一层点击表情添加到Input 
  $("body").on('click','#hiddenPhiz img',function(){
    var sign = $('#hiddenPhiz').attr('sign');//这个是在html页面动态添加的一个标识符用来匹配 输入到个框里面
    var Obj = $('input[sign='+sign+']');
    if(sign == 'topWB'){//这里只有一个 就是 最上面的输入框 ,这里就偷懒了
      Obj = $('textarea[name=operationContenti]');
    }
    var phiz = "["+this.alt+"]";
    Obj.val(Obj.val()+phiz);//插入内容进去
  });


/**
 * 转发输入框 点击弹出
 */
var oOperation   = $("a.operation");//页面转发 点击触发
var oObj         = $("div.moverHidOper");//被拖动的
var oEvent       = $("#hiddenOperationBox div.content");//拖动触发对象
var oPerationBox = $("#hiddenOperationBox");//主要转发box(全屏的)
var oIconCross   = $("i[name=icon-cross]");//XX
$("body").on("click","a.operation",function(){
  oPerationBox.find('input[name=tid]').val('0');//这里是补救方法 ,因为转发后或者打开抓发框不转发tid会保留下来
  //这里要判断下是不是用户本身转发的微博,若是着返回false
  var operationId = $(this).closest('footer').siblings('header').find('span.username').attr('userid');
  var beiisturn   = $(this).closest('div.forwardingIFM').siblings('h4.userIFM').find('a').eq(0).attr('name');
  if($('input[name=sessionUid]').attr('value')==operationId || $('input[name=sessionUid]').attr('value')==beiisturn){
    tishi('您不能转发自己的微博~');
    return false;
  }
  var sPContent = $(this).closest('footer').siblings('p').html();//closest()这个是向上获得第一个父级  //获取内容
  var sUsername = $(this).closest('footer').siblings('header').find('span.username a').html();//获取转发用户名
  var sUserUrl  = $(this).closest('footer').siblings('header').find('a').attr('href');//获取名字点击跳转地址
  var sWid      = $(this).attr('id');//该文档的ID
  var sCont     = '';//用来获取转发用转发的内容


//判断多转发框  用a连接点击转发时 判断的是多转,还是单转 还是转源
  if($(this).attr('tid')){//判断是多转
    sPContent = $.trim($(this).closest('footer').siblings('div.userforwarding').find('p.forwardingContent').html());//转发主要内容
    sUserUrl  = $(this).closest('footer').siblings('div.userforwarding').find('a.userNameisturn').attr('href');//获取名字点击跳转地址
    sCont     = $.trim($(this).closest('footer').siblings('p.content').html());
    sCont     = '// @'+sUsername+' : '+replace_weibo(sCont);
    oPerationBox.find('input[name=tid]').val($(this).attr('tid'));//获取所转发的主ID
  }
  if($(this).attr('yid')){//判断是转发源微博的
    sUsername = $(this).closest('div.forwardingIFM').siblings('h4.userIFM').find('a').eq(0).html();//获取转发用户名
    sPContent = $(this).closest('div.forwardingIFM').siblings('p.forwardingContent').html();//转发主要内容
    sUserUrl  = $(this).closest('div.forwardingIFM').siblings('h4.userIFM').find('a').eq(0).attr('href');//获取名字点击跳转地址
    sWid      = $(this).attr('yid');//BUG好多 这里就是解决读取不到wid的问题
  }

  $('#isturnIFM').html(sCont);
  $('textarea[name=operationContento]').val('');//这里是解决一个BUG因为有俩输入框
  $('#operationUsername').html('@' + sUsername);//转发框注入用户名
  $('#operationUsername').attr({'href':sUserUrl});//注入头像跳转地址
  $('#operationSpan').html('　'+sPContent);//注入内容
  oPerationBox.find('input[name=wid]').val(sWid);
  oPerationBox.fadeIn();
  $('textarea[name=operationContento]').focus();
  return false;
});

//拖拽效果调用的是 Tool.js 的函数          转发
drag(oEvent,oObj);
//点击XX关闭                               转发
oIconCross.click(function(){
    oPerationBox.fadeOut();
})

//键盘弹起转发 微博剩余数量提示
$('textarea[name=operationContento]').keyup(function(){ 
  var str = $(this).val();
  var lengths =check(str);
  var num = 140-Math.ceil(lengths[0]);
  var msg = num<0 ? 0 : num;
  $('#font-numo').html(msg);
})
//转发框 输入表情
  var oPhiz    = $('div[name=hiddenPhizO] img');
  var oPhizXX   = $('i[name=x]');
$("body").on('click','#icon-smileOperation',function(event){//因为这个转发是绝对定位,所以这里先获得鼠标的相对于文档的绝对位置
    var e = event || window.event;
    var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
    var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
    var x = e.pageX || e.clientX + scrollX;
    var y = e.pageY || e.clientY + scrollY; 
    $('#hiddenPhiz').css({
      'zIndex':200,
      top:y+18,
      left:x
    });
  });
  //点击图片添加到内容中  就是表情
  oPhiz.click(function(){
  var phiz = "["+this.alt+"]";
  var Obj = $('textarea[name=operationContento]');
  Obj.val(Obj.val()+phiz);//插入内容进去
  })
  oPhizXX.click(function(){
      $('#hiddenPhiz').fadeOut();
  })

//转发判断 ,判断内容不能为空
$('#operationFromSbt').click(function(){
  var content = $('textarea[name=operationContento]');
  if(trim(content.val()) == ''){
    flashingRed(content);
    return false;
  }
  content.val(content.val()+$('#isturnIFM').html());
})

/**
 * 替换微博内容，去除 <a> 链接与表情图片
 */
function replace_weibo (content) {
  content = content.replace(/<img.*?title=['"](.*?)['"].*?\/?>/ig, '[$1]');
  content = content.replace(/<a.*?>(.*?)<\/a>/ig, '$1');
  return content.replace(/<span.*?>(\/\/)<\/span>/ig, '$1');
}
})