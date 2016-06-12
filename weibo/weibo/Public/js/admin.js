$(function(){


//锁定用户AJAX发送处理
$('a.locks').click(function(){
  var uid = $(this).attr('uid');
  var status = $(this).attr('status');
  var lock = '';
  var oThis = $(this);
  if(status == '锁定'){//判断切换后该怎显示
    lock = '未锁定';
  }else{
    lock = '锁定';
  }
  $.post(locksUrl,{uid:uid,status:status},function(data){
    if(data.status){
      oThis.html(lock);
      oThis.attr('status',lock);
    }else{
      alert(data.msg);
    }
  },'json');
  return false;
});




})