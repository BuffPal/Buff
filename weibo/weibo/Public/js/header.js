$(function(){

  //这里是用来 导航栏搜索 的最新内容 就是如果用户输入搜索内容的话 默认搜索当前显示的最热内容
  var oSbt  = $('#sosoBtn');
  var oSoso = $('#soso');
  oSbt.click(function(){
    if(!Session){
    tishi('您还未登陆~ 马上跳转');
      setTimeout(function(){
        window.location.href=LoginUrl; 
    },2000);
      return false;
    }
    var a = oSoso.attr('placeholder');
    if(oSoso.val() == ''){
      oSoso.val(a);
    }
  })



/**
 * 背景图更换 效果处理
 */
var oChangeBgBox     = $('#changebgBox');
var oChangeBgElement = $('#changebgMove');
$('img.changeBg').click(function(){
  oChangeBgBox.fadeIn();
})
$('a.changeBgA').click(function(){
  oChangeBgBox.fadeIn();
});
drag(oChangeBgBox,oChangeBgElement);//拖动函数
$('#changebgBox img').click(function(){
  var style = $(this).attr('alt');
  $(this).addClass('changeBgClick').siblings('img.changeBgClick').removeClass('changeBgClick');
  $('input[name=changeBgStyle]').val(style);
})

//取消 隐藏
var ox       = oChangeBgBox.find('p.x');
ox.click(function(){
  $('#changebgBox img').removeClass('changeBgClick');
  oChangeBgBox.fadeOut();
});

//点击发送异步更换模板
var oChangeBgSendc    = oChangeBgBox.find('p.sendc');
oChangeBgSendc.click(function(){
  var style = $('input[name=changeBgStyle]').val();
  if(style == '0') return false;
  $.post(changeBgUrl,{style:style},function(data){
    if(data.status){
      window.location.reload();//刷新
    }else{
      tishi(data.msg);
    }
  },'json');
})




})