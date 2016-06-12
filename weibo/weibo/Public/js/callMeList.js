$(function(){
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
  });


/**
 * 发送私信处理
 */
//拖动
var oCallMeBox = $('#callMeBox');
var oElement   = $('#callMeMove');
var oSend      = oCallMeBox.find('span.send');//发送框点击
var oName      = oCallMeBox.find('input[name=callName]');
var oContent   = oCallMeBox.find('textarea[name=callContent]');
drag(oCallMeBox,oElement);//拖动函数

//点击发送私信弹窗
$('a.callClick').click(function(){
  var fromName = $(this).attr('fromName');
  oSend.attr({'fid':0});
  if(fromName != ''){//这里一共回复判断 一个是发送判断
    var fid = $(this).attr('fromId');
    oName.val(fromName);
    oSend.attr({'fid':fid});
  }
  oCallMeBox.fadeIn();
  return false;
});

//取消点击
var ox       = oCallMeBox.find('span.x');
ox.click(function(){
  oCallMeBox.fadeOut();
  oName.val('');//关闭时,清空数据
  oContent.val('');
});

//用户名ajax 判断用户是否存在
oName.click(function(){
  $('#callNameTishi').html('');
});
oName.blur(function(){
  var name = $.trim(oName.val());
  if(name){
    $.post(checkNameUrl,{'name':name},function(data){
      if(data.status){
        oSend.attr({'fid':data.fid});
        $('#callNameTishi').html('');
        $('#callNameTishi').fadeOut();
      }else{
        oSend.attr({'fid':'0'});
        $('#callNameTishi').html(data.msg);
        $('#callNameTishi').fadeIn();
      }
    },'json');
  }
})

//发送私信 AJAX 处理
oSend.click(function(){
  var fid     = $(this).attr('fid');
  var content = $.trim(oContent.val());
  if(fid == '0'){//用户不存 包括判断没输入
    flashingRed(oName);
    return false;
  }
  if(content == ''){//没有私信内容
    flashingRed(oContent);
    return false;
  }
  $.post(sendCallUrl,{'from':fid,'content':content},function(data){
    if(data.status){
      oCallMeBox.fadeOut();
      tishi(data.msg);
      oName.val('');//关闭时,清空数据
      oContent.val('');
      oSend.attr({'fid':'0'});
    }else{
      tishi(data.msg);
      oName.val('');//关闭时,清空数据
      oContent.val('');
      oSend.attr({'fid':'0'});
    }
  },'json');
});

//删除私信处理
var oCallCount = $('h1.callMeListTitle').find('strong');
var cNum = parseInt(oCallCount.html());
$('a.deleteCallClick').click(function(){
  var result = confirm('确认删除么~');
  if(result){
    var cid = $(this).attr('cid');
    var oLi = $(this).closest('li');
    $.post(callDeleteUrl,{'id':cid},function(data){
      if(data.status){
        oCallCount.html(cNum-1);//条数加-1
        tishi(data.msg);
        oLi.slideUp(800,function(){
          oLi.remove();
        });
      }else{
        tishi(data.msg)
      }
    },'json');
  }
  return false;
})




})