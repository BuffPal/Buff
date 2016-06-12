$(function(){

  //用来判断是否是 点击头像进来的
  var oA = $('#userNav a');
  if(type){//没有优化
    oA.eq(1).addClass('click');
    oA.eq(0).removeClass('click');
    oA.eq(2).removeClass('click');
    for(var i =1;i<=oA.length;i++){//无脑补救
      $("#show"+i).hide();
    }
      $("#show"+2).show();
  }

  //用户个人设置 导航栏切换
  var oA = $('#userNav a');
  oA.click(function(){
    var index = oA.index(this);//这里是布局出问题了 没考虑太多 ,偷个懒 补救下
    var eq = index+1;
    oA.removeClass('click');
    $(this).addClass('click');
    for(var i =1;i<=oA.length;i++){//无脑补救
      $("#show"+i).hide();
    }
    $("#show"+eq).show();
    return false;
  })



  //取得用户默认星座
  $('select[name=night]').val(constellation);

  //城市联动默认设置 已经在jquery.cityselect.js 里面配置了
  

  //Uploadify 插件头像上传
  $('#face').uploadify({
    swf:PUBLIC+'/Uploadify/uploadify.swf',            //引入Uploadify 核心Flash 文件
    uploader:uploadFace,                              //PHP处理图像上传脚本 处理地址
    width:120,                                        //上传按钮宽度
    height:30,                                        //上传按钮高度
    buttonImage:PUBLIC+'/Uploadify/browse-btn.png',   //上传按钮背景图地址
    fileTypeDesc:'Image File',                        //选择文件提示文字   没啥用主要是配合下面用
    fileTypeExts:'*.jpeg; *.jpg; *.png; *.gif',       //允许上传图片类型
    formData:{'session_id' : sid},//18课 20分钟详讲  //这里的session_id 3.2.3版本在 thinkphp config 里面默认是注释的需要手动打开
    onUploadSuccess:function(file,data,response){     //上传成功后的回调函数 只需要用data  是php返回的
      eval('var data =' + data);//这个函数是用来吧 data这个字符串转换为 对象的函数
      if(data.status){
        $('#userFace').attr('src',ROOT+data.facePath);
        $('input[name=faceSql]').val(data.facePath);
      }else{
        alert('上传失败,请重新尝试或换张图试试~');
      }
    }
  });
})