$(function(){

  /**
   * 点击 未关注 已关注 互相关注 发送ajax
   */
    var oObj         = $("div.moverHidOper");//被拖动的
    var oEvent       = $("#hiddenOperationBoxS div.content");//拖动触发对象
    var oCount       = $('#count');//全部粉丝/关注 的统计
    var sNum         = parseInt(oCount.html());
    var oIconCross   = $("input.icon-cross");//XX
    var oPerationBox = $("#hiddenOperationBoxS");//主要转发box(全屏的)
  $('body').on('click','span.follow',function(){
    var uid          = $(this).attr('uid');
    var mutual       = $(this).attr('mutual');
    var othis        = $(this);
    if(mutual != '0'){//这个判断的是 已经关注的用户 点击后给他处理取消关注
      $.post(unFollow,{'follow':uid},function(data){
        if(data.status){
          othis.html('未关注');
          othis.removeClass('selected');
          othis.attr({'mutual':0});
          tishi(data.msg);
        }else{
          tishi(data.msg);
        }
      },'json');
    }else{//这里是关注  用来弹出关注分组框
      var uidfollow = $(this).attr('uid');
      $('input[name=follow]').val(uidfollow);//传入当前用户的ID 就是 uid
      oPerationBox.show();//显示关注框
      oPerationBox.animate({'opacity':1},400);
    }
  })



  //拖拽效果调用的是 Tool.js 的函数          转发
  drag(oEvent,oObj);
  //点击XX关闭                               转发
  oIconCross.click(function(){
    oPerationBox.animate({'opacity':0},400,function(){
    oPerationBox.hide();
  })
  })



/**
 * 点击关注后发送Ajax 处理关注
 */
  var oAddFollowBtn = $('#addFollowBtn');
  var oGroupSelect  = $('#group');
  oAddFollowBtn.click(function(){
    var followId = $('input[name=follow]').val();//当前需要发送 ajax 用户的ID
    var gid      = oGroupSelect.val();
    //发送Ajax
    $.post(addFollowUrl,{'gid':gid,'follow':followId},function(data){
      if(data.status){//判断是否成功
        $('span[uid='+followId+']').html('已关注').addClass('selected').attr({'mutual':1});
        oPerationBox.animate({'opacity':0},400,function(){//关闭弹窗
          oPerationBox.hide();
        });
        tishi('关注成功~');
      }else{
        alert(data.msg);
      }
    },'json');
  });



  /**
   * 没有分组?点击添加  好吧这个我是复制过来的
   */
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