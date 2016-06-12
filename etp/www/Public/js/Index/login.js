$(function(){
  /**
   * 注册背景图片切换
   */
  var i = 2;
  setInterval(function(){
    //分别获得两个div的url和当前的图片
    var sImgUrl1 = document.getElementById('img').style.backgroundImage;
    var NowNum1  = sImgUrl1.match(/(.*)(\w)\.jpg(.*)/)[2]; 
    var sImgUrl2 = document.getElementById('img2').style.backgroundImage;
    var NowNum2  = sImgUrl2.match(/(.*)(\w)\.jpg(.*)/)[2]; 

    $('#img').animate({
      opacity: 0
    },2000,'easeInQuart',function(){
      //第一张图
      var url1 = sImgUrl1.replace(/(.*)\/([\d]*)\.jpg(.*)/, "$1/"+(i)+".jpg"+"$3");
      $('#img').css({backgroundImage:url1});
      $('#img').animate({opacity:1},400,'',function(){

        i = parseInt((Math.random()*21)+1);
        //第二张图
        var url2 = sImgUrl2.replace(/(.*)\/([\d]*)\.jpg(.*)/, "$1/"+(i)+".jpg"+"$3");
        $('#img2').css({backgroundImage:url2});
      })
    });
    

  },4000);

})