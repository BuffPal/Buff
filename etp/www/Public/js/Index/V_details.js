$(function(){
/**
 * video 插件控制
 */
//这里因为用 container所以只有width能控制到100% height 无法控制到
// (($('#video2').css('width'))/0.8) 宽度
$('#video2').css('height',parseInt(($('#video2').css('width')))/1.777);
$('#videoPlayer .list').css('height',parseInt(($('#video2').css('width')))/1.777);

//点击跳转(这里用的span因为懒)
$('span.href').on('click',function(){
  window.location.href = $(this).attr('href');
})
  
/**
 * 点击赞 后台点赞 - - 
 */
$('#topcount').on('click',function(){
  //获取当前视频ID
  var vid = $(this).attr('videoid');
  //获取点击下面的I数据
  var oI = $(this).find('i');
  var sI = parseInt(oI.html());
  //发送ajax
  $.post(topcountAjaxUrl,{
    vid:vid
  },function(data){
    if(data.status){
      oI.html(' '+(sI+1));
    }else{
      tishi(data.msg)
    }
  },'json');
});

})