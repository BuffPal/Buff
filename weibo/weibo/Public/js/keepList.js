$(function(){
  //用来控制用户输入 字符剩余提示
  $('textarea[name=operationContenti]').keyup(function(){ 
    var str = $(this).val();
    var lengths =check(str);
    var num = 140-Math.ceil(lengths[0]);
    var msg = num<0 ? 0 : num;
    $('#font-num').html(msg);
  });

  ///////////////////////////////////////还没有分组?点击添加/////////////////
  var oaddGroup    = $('#addGroupAjax');
  var oaddText     = $('#addGroupText');
  var oaddGroupBtn = $('#icon-plus2');
  var oselect      = $('#ulBottom');
  oaddText.blur(function(){//因为没有添加删除功能,所以 用定时器做,失去焦点判断
    window.timeout = setTimeout(function(){
      oaddText.stop(true,true);
      oaddText.animate({width:0},200,'',function(){//只是加了一个动画平滑一点
          oaddText.hide();
          oaddGroupBtn.hide();
        },2);
    },6000);
  });
  oaddGroup.click(function(){//点击没有分组 添加分组 后显示 添加分组框
    clearTimeout(window.timeout);
    oaddText.show();
    oaddText.stop(true,true);
    oaddText.animate({width:80},800,'',function(){//加了一个动画
       oaddGroupBtn.css({width:40,display:'inline-block'});
       oaddGroupBtn.animate({opacity:1},400);
    });
    return false;
  });
  oaddGroupBtn.click(function(){//点击添加后发送AJAX
    var string = trim(oaddText.val());//去除两边的空格
    if(string == '') return false;//如果为空则不输入
    $.post(addGroupUrl,{'name':string},function(data){
      if(data.status){//添加成功
        $liHtml = '<li><i class="icon-user-tie"></i><a href="" value='+data.lastId+'>'+string+'</a></li>';
        oselect.append($liHtml);
        //隐藏添加
        oaddText.stop(true,true);
        oaddText.animate({width:0},200,'',function(){//只是加了一个动画平滑一点
          oaddText.hide();
          oaddGroupBtn.hide();
        },200);
      }else{//添加失败
        alert(data.msg);
        oaddText.focus();
      }
    },'json');
  })


/**
 * 鼠标移入li 显示删除按钮
 */
$("body").on('mouseenter','#blogUl>li',function(){
  var session = $('div.userIFM').attr('value');//判断该微博时候是自己发布的,不是就不显示删除
  var WbUid   = $(this).find('h4.userIFM').attr('value');
  if(session == WbUid){
    $(this).find('a.deleteWB').fadeIn();
  }
});

//移出
$("body").on('mouseleave','#blogUl>li',function(){
  $(this).find('a.deleteWB').fadeOut();
});

//点击后处理删除ajax
$("body").on('click','a.deleteWB',function(){
  var wid = $(this).attr('wid');
  var oLi  = $(this).closest('li');
  $.post(deleteWbUrl,{'wid':wid},function(data){
    if(data.status){
      oLi.fadeOut();
    }else{
      tishi('删除失败,服务器正忙~');
    }
  },'json');
  return false;
})



/**
 * 评论处理
 */
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

  //点击图片 显示表情隐藏的pictureHiddenBox
  var oPictureHiddenBox = $('#pictureHiddenBox');
  var oPicture          = $('#picture');
  var oX                = $('#picture i.icon-cross');
  oPicture.click(function(){//点击显示
    oPictureHiddenBox.show();
    oPictureHiddenBox.animate({'opacity':1,'top':250},300);
  })
  oX.click(function(){//点击X隐藏
      oPictureHiddenBox.animate({'opacity':0,'top':-50},300,function(){
         oPictureHiddenBox.hide();
      });
    })


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


   //回复回复评论点击 发送Ajax  第一个评论回复
 $("body").on('click','span.commentE',function(){
    var sContent = $(this).closest('div.phiz').siblings('div.input').children('input[name=comment]');
    var oUl      = $(this).closest('div.publish').siblings('div.list_ul');
    var oNum     = $(this).closest('div.comment').siblings('article.excerpt').find('a.commentE').find('span');//获取当前评论
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

  //回复点击显示/隐藏
  $("body").on('click','a.commentE',function(){
    var hideObj       = $(this).closest('article.excerpt').siblings('div.comment');
    var oLoginanimate = $(this).closest('article.excerpt').siblings('div.comment').find('div.animate');
    if(hideObj.css('display') == 'none'){//来回点击判断
      //去后台AJAX取数据
      var wid   = $(this).attr('wid');//该文档的ID
      //发送ajax请求
      var ul    = hideObj.find('div.list_ul');//这个为了注入节点
      var count = hideObj.find('div.moreReply').find('a');//查看更多的评论
      $.ajax({
        url : CommentListUrl,
        data : {'wid':wid},
        type : 'post',
        dataType: 'json',
        beforeSend : function(){//加载
          oLoginanimate.fadeIn(200);
        },
        success : function(data){
          ul.append(data.data);//注入用户评论list
          if(data.count == 0){//判断该如何显示 查看更多评论
            count.html('暂没有任何评论~');
          }else if(data.count <= 10){
            count.html('');
          }else{
            count.html('查看更多评论 ('+((data.count)-10)+')');
          }
        },
        complete : function(){//完成
          oLoginanimate.hide();
        }
      })

      hideObj.fadeIn();
      hideObj.children('input').focus();//获取焦点
      return false;
    }else{
      hideObj.fadeOut();
      hideObj.find('div.list_ul').find('div.list_li').remove();
    }
    return false;
  });


  //回复用户回复 处理   有点绕口
  $("body").on('click','p.supportClick',function(){
    var hideObj = $(this).closest('div.time').siblings('div.reply');
    if(hideObj.css('display') == 'none'){
      hideObj.fadeIn();
      hideObj.children('input').focus();//获取焦点
    }else{
      hideObj.fadeOut();
    }
    return false;
  });

  //评论 点击Img添加到输入框
  $("body").on('click','span.replyByReply div[name=hiddenPhizO] img',function(){
    var phiz = "["+this.alt+"]";
    var Obj = $(this).closest('span.replyByReply').siblings('input');
    Obj.val(Obj.val()+phiz);//插入内容进去
  });

  //回复回复评论点击 发送Ajax
  $("body").on('click','span.replyByReply>span',function(){
    var sContent = $(this).closest('div.reply').find('input.reply');
    if($.trim(sContent.val()) == ''){
      flashingRed(sContent);//闪烁红光
      sContent.focus();
      return false;
    }else{
      alert('通过')
    }
  })

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
  })


/**
 * 用户收藏处理
 */
 $("body").on('click','a.keep',function(){
  var status = $(this).find('span').html();
  if(status == '已收藏') return false;
  var wid = $(this).attr('wid');
  $.post(keepUrl,{'wid':wid},function(data){//ajax收藏
    if(data.status){
      tishi(data.msg);
    }else{  
      tishi(data.msg);
    }
  },'json');
  return false;
 });




/**
 * 用户取消收藏处理
 */
$("body").on('click','a.keep',function(){
  var status = $(this).find('span').html();
  if(status == '收藏') return false;
  var wid    = $(this).attr('wid');
  var result = confirm('您确定取消么');
  var oLi    = $(this).closest('footer').closest('li');
  if(!result) return false;
  $.post(unKeepUrl,{wid:wid},function(data){
    if(data.status){
      oLi.fadeOut(200,function(){
        oLi.remove();
      });
      tishi(data.msg);
    }else{
      tishi(data.msg)
    }
  },'json');
  return false;
});

/**
 * 切换分组显示
 */
$('body').on('click','#ulBottom li>a',function(){
  //这里要恢复 一下 滚动条读取数据的判断
  $('#notData').remove();
  on = true;//开启开关
  $('input[name=nowGroup]').val($(this).attr('gid'));//这里给他注入 组ID主要是为了滚动条加载Ajax 的时候读取指定gid的数据
  $.post(getGidUrl,{'gid':$(this).attr('gid')},function(data){
    $('#blogUl>li').remove();//清除当前ul的内容
    $('#blogUl').prepend(data.html);
  },'json');
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
  var operationId = $(this).closest('footer').siblings('header').find('h4').attr('value');
  var beiisturn   = $(this).closest('div.forwardingIFM').siblings('h4.userIFM').find('a').eq(0).attr('name');
  if($('div.userIFM').attr('value')==operationId || $('div.userIFM').attr('value')==beiisturn){
    tishi('您不能转发自己的微博~');
    return false;
  }
  var sPContent = $(this).closest('footer').siblings('p').html();//closest()这个是向上获得第一个父级  //获取内容
  var sUsername = $(this).closest('footer').siblings('header').find('a').html();//获取转发用户名
  var sUserUrl  = $(this).closest('footer').siblings('header').find('a').attr('href');//获取名字点击跳转地址
  var sWid      = $(this).attr('id');//该文档的ID
  var sCont     = '';//用来获取转发用转发的内容


//判断多转发框  用a连接点击转发时 判断的是多转,还是单转 还是转源
  if($(this).attr('tid')){//判断是多转
    sUsername = $(this).closest('footer').siblings('header').find('h4.userIFM').find('a').eq(0).html();//获取转发用户名

    sPContent = $.trim($(this).closest('footer').siblings('div.userforwarding').find('p.forwardingContent').html());//转发主要内容
    sUserUrl  = $(this).closest('footer').siblings('div.userforwarding').find('a.userNameisturn').attr('href');//获取名字点击跳转地址
    sCont     = $.trim($(this).closest('footer').siblings('p.blogContent').html());
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
 


 /**
  * 这个js是给atmeList.html 用的 应为它调用的也是这个模板
  */
  $('a.deleteat').click(function(){
    var wid    = $(this).attr('wid');
    var oLi    = $(this).closest('li');
    var result = confirm('您确定要清除么~');
    if(!result) return false;
    $.post(deleteatUrl,{'wid':wid},function(data){
      if(data.status){
        tishi(data.msg);
        oLi.fadeOut(400,function(){
          oLi.remove();
        })
      }else{
        tishi(data.msg)
      }
    },'json');
    return false;
  })















})