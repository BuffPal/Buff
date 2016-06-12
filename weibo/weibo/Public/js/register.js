$(function(){
  /**
   * 注册页面JS
   */
  //验证码点击切换
  var oImgVerify    = $('img.verify');
  var oImgVerifySrc = oImgVerify.attr('src');
  oImgVerify.click(function(){
    $(this).attr('src',oImgVerifySrc +'/'+Math.random())
  })

  //AJAX验证
  var oAccount = $('input[name=account]');
  oAccount.blur(function(){
    $.post(AjaxUrl,{
      'account':oAccount.val()
    },function(data){
      alert(data);
    },'json');
  })







})