/**
 * 判断是否是IE用户
 * @return {Boolean} [跳转到指定页面]
 */
function isIE(){
  var browser=navigator.appName
  var a1 = navigator.userAgent;
  var yesIE = a1.search(/Trident/i);
  if(browser=="Microsoft Internet Explorer" )
  {
  window.location.href="isie.html";
  }
//判断是否为IE浏览器包括IE11

/*if(yesIE>0){
  window.location.href="isie.html";
}*/
}


/**
 * 用于实现Jquery的封装class 的 增删改查
 * @param  {[type]}  obj [对象]
 * @param  {[type]}  cls [className]
 * @return {Boolean}     [NO]
 */
function hasClass(obj, cls) {  
    return obj.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));  
}  
  
function addClass(obj, cls) {  
    if (!this.hasClass(obj, cls)) obj.className += " " + cls;  
}  
  
function removeClass(obj, cls) {  
    if (hasClass(obj, cls)) {  
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');  
        obj.className = obj.className.replace(reg, ' ');  
    }  
}  
  
function toggleClass(obj,cls){  
    if(hasClass(obj,cls)){  
        removeClass(obj, cls);  
    }else{  
        addClass(obj, cls);  
    }  
}  

/**
 * backTop 的定时器
 */
function backTopa(time,v,top){
  if(!top){
    alert('backTopa()第三个参数必须为0以上的值');
    return false;
  }
  if(document.documentElement.scrollTop){
    var timer1 = setInterval(function(){
      document.documentElement.scrollTop = document.documentElement.scrollTop-v;
      if(document.documentElement.scrollTop < top){
       clearInterval(timer1);
       return true;
      }
    },time);
  }
  if(window.pageYOffset){
    var timer2 = setInterval(function(){
      window.pageYOffset = window.pageYOffset-v;
      if(window.pageYOffset < top){
       clearInterval(timer2);
       return true;
      }
    },time);
  }
  if(document.body.scrollTop){
    var timer3 = setInterval(function(){
      document.body.scrollTop = document.body.scrollTop-v;
      if(document.body.scrollTop < top){
       clearInterval(timer3);
       return true;
      }
    },time);
  }
}

/**
 * AJAX封装
 */
function ajax(json){
  alert(json);
  //接受json参数
  var type = json.type || 'GET';
  var data = json.data || '';
  var url  = json.url;
  var dataType = json.dataType || false;
  var success = json.success;
  var error = json.error || false;
  var oAjax;
  //创建AJAX对象
  if(window.XMLHttpRequest){//非ie6
    oAjax = new XMLHttpRequest();
  }else{// IE6
    oAjax = new ActiveXObject("Microsoft.XMLHTTP");
  }
  //链接服务器
  oAjax.open(type,url,true);
  //发送服务器
  oAjax.send(data);
  //接受返回值
  oAjax.onreadystatechange = function(){
    if(oAjax.readyState ==4 ){//返回的请求完成
      if(oAjax.status ==200){//请求成功
        var dataStr = oAjax.responseText;//返回数据
        if(dataType == 'json'){
          success(eval('('+dataStr+')'));
        }else{//直接返回
          success(dataStr);
        }
      }else{
        if(error){
          error()
        }
      }
    }
  }
}