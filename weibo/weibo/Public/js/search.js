$(function(){
//点击关注 弹出判断  先判断是否登录  0 无  1登   这个是复制过来的
  var oOperation   = $("input.operation");//页面关注 点击触发
  var oObj         = $("div.moverHidOper");//被拖动的
  var oEvent       = $("#hiddenOperationBoxS div.content");//拖动触发对象
  var oPerationBox = $("#hiddenOperationBoxS");//主要转发box(全屏的)
  var oIconCross   = $("input.icon-cross");//XX
  var oEventFollow;
  oOperation.click(function(){
    oEventFollow = $(this);
    var statusIf = $(this).attr('status');
    if(statusIf != 0){//这个是判断该点击的用户是否已经被关注  如果不定于0的话 ,点击给他取消
      var followId = $(this).attr('uid');//获取当前点击对象的ID
      $.post(unFollowUrl,{'follow':followId},function(data){
        if(data.status){
              oEventFollow.val('关注').removeClass('mutual').attr({'status':0});
               //给对应的粉丝数量-1 这个有点麻烦 复制过来的
                var oFans = oEventFollow.siblings('p.star_num').find('a.fansCount');
                var iFansNum = parseInt(oFans.html())-1;
                tishi('取消成功');
                oFans.html(iFansNum);
        }else{
          alert(data.msg);
        }
      },'json');
    }else{//该用户未被关注
      //建立一个隐藏域 用于发送被关注用户的ID
      oEventFollow = $(this);     //点击获取当前的触发对象用于下面发送AJAX后的修改样式
      var followId = $(this).attr('uid');
      $('input[name=follow]').val(followId);//吧当前点击用户的ID传给 弹出框里面的隐藏域
      oPerationBox.show();
      oPerationBox.animate({'opacity':1},400);
    }
    return false;
  })



//点击关注后发送Ajax 处理关注
  var oAddFollowBtn = $('#addFollowBtn');
  var oGroupSelect  = $('#group');
  oAddFollowBtn.click(function(){
    var followId = $('input[name=follow]').val();
    var gid      = oGroupSelect.val();
    //发送Ajax
    $.post(addFollowUrl,{'gid':gid,'follow':followId},function(data){
      if(data.status){//判断是否成功
        oEventFollow.val('已关注').addClass('mutual').attr({'status':1});
        oPerationBox.animate({'opacity':0},400,function(){//关闭弹窗
          oPerationBox.hide();
        });
        //给对应的粉丝数量+1 这个有点麻烦
        var oFans = oEventFollow.siblings('p.star_num').find('a.fansCount');
        var iFansNum = parseInt(oFans.html())+1;
        tishi('关注成功~');
        oFans.html(iFansNum);

      }else{
        alert(data.msg);
      }
    },'json');
  });



//拖拽效果调用的是 Tool.js 的函数          转发
  drag(oEvent,oObj);
  //点击XX关闭                               转发
  oIconCross.click(function(){
    oPerationBox.animate({'opacity':0},400,function(){
    oPerationBox.hide();
  })
  })



////////////////////////////////////////来判断keyword是否为空 为空是搜索出来全部的数据,致命BUG
  var oKeyword     = $('#keyword');
  var oKeywordSend = $('#keywordSend');
  var oSoso        = $('#soso');
  var sHotSoso     = oSoso.attr('placeholder');
  oKeywordSend.click(function(){//点击搜索判断
    var string = trim(oKeyword.val());//去除前后空格
    if(string == ''){
      oKeyword.attr('value',sHotSoso);//用最新数据替换空的搜索
    }
  })
///////////////////////////////////////判断结束/////////////////////////////



///////////////////////////////////////还没有分组?点击添加/////////////////
  var oaddGroup    = $('a.addGroup');
  var oaddText     = $('#addText');
  var oaddGroupBtn = $('#addGroupBtn');
  var oselect      = $('#group');
  oaddGroup.click(function(){//点击没有分组 添加分组 后显示 添加分组框
    oaddText.show();
    oaddText.animate({width:80},800,'',function(){//加你一个动画
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
        $selectHtml = '<option value="'+data.lastId+'" selected="selected">'+string+'</option>';
        oselect.append($selectHtml);
        //隐藏添加
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






})