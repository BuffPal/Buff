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
   * 删除评论处理
   */
  var oCallCount = $('h1.callMeListTitle').find('strong');
  var cNum = parseInt(oCallCount.html());
  $('a.deleteCallClick').click(function(){
    var result = confirm('确认删除么~');
    if(result){
      var cid = $(this).attr('cid');
      var oLi = $(this).closest('li');
      $.post(deleteCommentUrl,{'id':cid},function(data){
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
  });


})