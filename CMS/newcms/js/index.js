isIE();
window.onload = function(){
  ///////////////////////////////////////////////////////////折纸动画/////////////////////////////////////
 var oHh2 = document.getElementById('h2');
 var oHWrap = document.getElementById('wrap');
 var oHA = oHWrap.getElementsByTagName('a');
 var aHDiv = oHWrap.getElementsByTagName('div');
 var iHDelay = 200;
 var oHTimer=null;
 var i = 0;
 var bOff=true;
 oHh2.onclick = function(){
  if(oHTimer){
    return;
  }
  if(bOff){
      i=0;
      oHTimer = setInterval(function(){
          aHDiv[i].className = "show";
          i++;
          if(i==aHDiv.length){
              clearInterval(oHTimer);
              oHTimer=null;
              bOff=false;
           }
       },iHDelay);
  }else{
    if (!bOff) {
     i=aHDiv.length-1;
    oHTimer = setInterval(function(){
          aHDiv[i].className = "hide";
          i--;
          if(i<0){
              clearInterval(oHTimer);
              bOff=true;
              oHTimer=null;
           }
       },iHDelay);
    }
  }
 }



 ////////////////////////////////////////////滚动条时间,让nav固定定位----包含返回顶部功能//////////////////////
 var backTop = document.getElementById('backTop');   /////////backtop
 /////////点击判断
  backTop.onclick = function(){
    backTopa(1,10,1);// 1. 定时器帧率   2.每减少的px    3.TOP到顶部多少距离停止
  }

 window.onscroll = function(){
  var oHNav = document.getElementById('oNav');
  var wHeight = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
  if(wHeight>84){
    addClass(oHNav,'navFixed');
    removeClass(backTop,'backTopHide');                   ///////////backtop
    addClass(backTop,'backTopShow');                   ///////////backtop
  }else{
    removeClass(oHNav,'navFixed');
    removeClass(backTop,'backTopShow');                     ////////backtop
    addClass(backTop,'backTopHide');                     ////////backtop
  }
 }
//解决刷新后必须要滚动滚动条 nav固定才能有效果
var wHeightF5 = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
var oHNav = document.getElementById('oNav');
 if(wHeightF5>84){
    addClass(oHNav,'navFixed');
    removeClass(backTop,'backTopHide');                   ///////////backtop
    addClass(backTop,'backTopShow');                   ///////////backtop
  }else{
    removeClass(oHNav,'navFixed');
    removeClass(backTop,'backTopShow');                     ////////backtop
    addClass(backTop,'backTopHide');                     ////////backtop
  }

  





}