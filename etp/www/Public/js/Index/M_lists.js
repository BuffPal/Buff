$(function(){
/**
 * 左侧点击,span(箭头),添加旋转动画(这里要默认给 collapse in加上 animation)
 */
$('#accordion').find('div.in').siblings('div').find('span.glyphicon').addClass('animation');
$('#accordion h4.panel-title a').click(function(){
  $('#accordion h4.panel-title a span.animation').removeClass('animation');
  var obj = $(this);
  if(obj.attr('aria-expanded') == 'true'){
    obj.find('span').removeClass('animation');
  }else{
    obj.find('span').addClass('animation');
  }
});

/**
 * 默认判断当前点击的二级导航 给他的第一级导航显示出来并且 给他加上 active
 */
var nowCid = $('#nowCid').val();
if(nowCid != ''){
  //获得当前cid所在的节点
  var oLi = $('li[cid='+nowCid+']');
  //获得他所在最上层用于执行显示的div
  var oWarp = oLi.closest('div.liwarp');
  //获取oWarp下面的小三角
  var oSan = oLi.closest('div.maxWarp').find('span.sanjiao');

  oSan.addClass('animation');
  oWarp.addClass('in');
  oLi.find('img').addClass('active');
}else{
  var oMaxWarp = $('div.maxWarp').eq(0);
  oMaxWarp.find('div.liwarp').addClass('in');
  oMaxWarp.find('span.sanjiao').addClass('animation');

}





  
})