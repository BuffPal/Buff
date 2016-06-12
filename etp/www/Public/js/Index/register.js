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



//jquery Validate 表单注册验证
  //判断是否以字母开头
  jQuery.validator.addMethod("Account1", function(value, element) {//改下函数名就行
      var tel = /^[a-zA-Z][\S 　]*?$/;
      return this.optional(element) || (tel.test(value));//不动
  }, "账号必须以字母开头");

  jQuery.validator.addMethod("Account2", function(value, element) {//改下函数名就行
      var tel = /^[\S]+[\u4E00-\u9FA5\w][\S]+$/;
      return this.optional(element) || (tel.test(value));//不动
  }, "账号不能为中文");

  //判断是否为特殊字符
  jQuery.validator.addMethod("Account3", function(value, element) {//改下函数名就行
      var tel = /^[a-zA-Z][\w]*?$/;
      return this.optional(element) || (tel.test(value));//不动
  }, "账号不能存在特殊字符!");

  //只能为中文和\w  就是判断是否为特殊字符
  jQuery.validator.addMethod("username1", function(value, element) {//改下函数名就行
      var tel = /^[\u4E00-\u9FA5\w]*?$/i;
      return this.optional(element) || (tel.test(value));//不动
  }, "昵称不能存在特殊字符!");

  //邮箱验证
  jQuery.validator.addMethod("checkEmail", function(value, element) {//改下函数名就行
      var tel = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
      return this.optional(element) || (tel.test(value));//不动
  }, "请输入真确的邮箱地址~");

 $('form[name=register]').validate({ 
    //不验证 验证码
    ignore:"#verify",
    //错误提示信息放到span标签里面
    errorElement:'span',
/*    success:function(label){
      label.addClass('success');
    },*/
    //验证规则编写
    rules :{
      //账号验证
      account:{
        required:true,
        Account1:true,
        Account2:true,    
        rangelength:[5,17],
        Account3:true,
        //异步验证
        remote:{
          url:checkAjaxUrl,
          type:'post',
          dataType:'json',
          data:{
            //这个传参方法有点另类  json格式为{account:$('#account').val()}
            account:function(){
              return $('#account').val();
            }
          }
        }
      },
      //用户名验证
      username:{
        required:true,
        rangelength:[2,10],
        username1:true,
        remote:{
          url:checkAjaxUrl,
          type:'post',
          dataType:'json',
          data:{
            //这个传参方法有点另类  json格式为{account:$('#account').val()}
            account:function(){
              return $('#username').val();
            }
          }
        }        
      },
      //密码验证
      password:{
        required:true,
        rangelength:[6,20]
      },
      //确认密码
      notPassword:{
        required:true,
        equalTo:"#password"
      },
      //邮箱验证
      email:{
        required:true,
        checkEmail:true,
        remote:{
          url:checkAjaxUrl,
          type:'post',
          dataType:'json',
          data:{
            //这个传参方法有点另类  json格式为{account:$('#account').val()}
            account:function(){
              return $('#email').val();
            }
          }
        } 
      }
    },
    //显示方式
    messages:{
      account:{
        required:'账号不能为空',
        rangelength:'请保证账号在5~17位',
        remote:'账号已被注册啦~'
      },
      username:{
        required:'请输入您的昵称',
        'rangelength':'名称因在2~10之间',
        remote:'昵称已被占用啦~'
      },
      password:{
        required:'请填写您的密码',
        rangelength:'密码因在6~20位之间'
      },
      notPassword:{
        required:'请确定您的密码',
        equalTo:'两次输入密码不一样~'
      },
      email:{
        required:'请输入您的电子邮箱',
        remote:'该邮箱已被注册啦~'
      }
    }

 });


/**
 * 一下要注意的问题,因为validate用了ajax验证,所以不能用input:submit 提交表单.
 * 需要用下面一段函数来执行提交
 * 这里要注意的是 不能用Input来触发click 要用别的东西如 button 并且ID不能为submit
 */
 var validator = $("#register").validate({meta: "validate"}); 
      // 点击“保存”按钮时先验证，验证通过后方能保存
     $("#submita").click(function() { 
       if(validator.form()){ //若验证通过，则调用修改方法
        //提交表单
           document.getElementById('register').submit();
        }
      });
/**
 * 到这里结束
 */
 

})