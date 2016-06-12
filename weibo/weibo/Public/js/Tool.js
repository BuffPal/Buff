/**
* 元素拖拽
* @param  obj   拖拽的对象
* @param  element   触发拖拽的对象
* PS : 这里obj 被拖拽的对象需要用 top left 来控制未触发时的位置 不能用 margin 0 auto
*/
function drag (obj, element) {
  var DX, DY, moving;
  element.mousedown(function (event) {
    obj.css( {
      zIndex : 1,
      opacity : 0.5,
      filter : 'Alpha(Opacity = 50)'
    } );
    DX = event.pageX - parseInt(obj.css('left')); //鼠标距离事件源宽度
    DY = event.pageY - parseInt(obj.css('top'));  //鼠标距离事件源高度
    moving = true;  //记录拖拽状态
  });

  $(document).mousemove(function (event) {
    if (!moving) return;

    var OX = event.pageX, OY = event.pageY; //移动时鼠标当前 X、Y 位置
    var OW = obj.outerWidth(), OH = obj.outerHeight();  //拖拽对象宽、高
    var DW = $(window).width(), DH = $(window).height();  //页面宽、高

    var left, top;  //计算定位宽、高

    left = OX - DX < 0 ? 0 : OX - DX > DW - OW ? DW - OW : OX - DX;
    top = OY - DY < 0 ? 0 : OY - DY > DH - OH ? DH - OH : OY - DY;

    obj.css({
      'left' : left + 'px',
      'top' : top + 'px'
    });

  }).mouseup(function () {
    moving = false; //鼠标抬起消取拖拽状态

    obj.css( {
      opacity : 1,
      filter : 'Alpha(Opacity = 100)'
    } );

  });
}

/**
 * 统计有多少字符，包括转换了中文和英文的转化
 */
function check(str){
  var num = [0,50];
  for(var i=0;i<str.length;i++){//这里用for是有点浪费系统资源了，每次输入都会循环
    if (str.charCodeAt(i) >= 0 && str.charCodeAt(i) <= 255){//如果是英文输入
      num[0] = num[0]+0.5;//这个是英文字母增加
      num[1] = num[1]+0.5;//这个看不懂
    }else{//下面是中文输入
      num[0]++;
    }
  }
  return num;
}

/**
 * 如PHP 的trim
 * @param  {[type]} str [需要去除的字符串]
 * @return {[type]}     [返回字符串]
 */
function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g,'');
}

/**
 * 闪烁效果
 * @param  {[type]} obj [需要闪烁的对象]
 * @return {[type]}     [description]
 */
function flashingRed(obj){
  obj.css({'background':'Crimson'});
     obj.animate({'opacity':0},200,'',function(){
      obj.animate({'opacity':.8},200,'',function(){
        obj.animate({'opacity':0},200,'',function(){
          obj.css({'opacity':1,'background':'white'});
        });
      });
     });
}

/**
 * 提示信息
 * @param  {[type]} str [提示内容]
 * @return {[type]}     [description]
 */
function tishi(str){
  $('#fade').stop(true,true);
  $('#fade>span').html(str);
  $('#fade').css({'background':'#ff4400'});
  $('#fade').fadeIn(1000);
  $('#fade').fadeOut(1000);
}
