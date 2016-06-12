<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
<style type="text/css">
  #videoPosterTest{
    display: block;
    border-radius: 3px;
    border: 2px solid #fff;
    box-shadow: 0px 0px 10px #333;
    transition: .5s;
  }
  #videoPosterTesta{
    display: block;
    position: absolute;
    left: 120%;
    top: -20px;
    z-index: 50;
  }
  #videoPosterTesta:hover >img{
    box-shadow: 0px 0px 20px #ff4400;
  }
</style>
  

<!-- 引入头文件 -->
<!-- bootstrap主要样式 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/bootstrap.min.css"  rel="stylesheet">
<!-- bootstrap自带模板 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/bootstrap-theme.min.css">
<!-- bootstrap按钮插件 -->
<link rel="stylesheet" type="text/css" href="/Public/css/plug-in/buttons.css">
<!-- 引入基本样式(常用的) -->
<link rel="stylesheet" type="text/css" href="/Public/css/Admin/basic.css">
<!-- 载入uploads上传插件CSS样式 -->
<link rel="stylesheet" type="text/css" href="/Public/Uploadify/uploadify.css">
<style type="text/css">
/**弹出效果**/
#fade{
  position:fixed;
  left: 40%;
  top: 38%;
  width: 200px;
  height: 40px;
  background: #fff;
  z-index: 9999;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0px 0px 10px #434343;
  display: none;
}
#fade>span{
  display: block;
  width: 100%;
  height: 40px;
  color: #FFFFFF;
  text-shadow: 1px 1px 2px #727272;
  font-size: 1.8rem;
  text-align: center;
  line-height: 40px;
}
</style>
<!-- Uploadify js定义 -->
<script type="text/javascript">
  var PUBLIC = "/Public";
  var uploadPosterUrl = "<?php echo U('Common/uploadVideoPoster');?>";//后台PHP处理地址


</script>
<div class="container-fulid">
  <ul class="breadcrumb">
    <li>
      <a href="#">视频管理</a> <span class="divider">/</span>
    </li>
    <li>
      <a href="<?php echo U('index');?>">视频列表</a> <span class="divider">/</span>
    </li>
    <li class="active">
      视频修改
    </li>
  </ul>
</div>

<div class="container">
  <h1 class="container-fluid col-md-12 text-center">视频修改</h1>
  <p>　</p>
  <form action="#" method="post" class="form-horizontal col-md-12">

        <div class="form-group" >
          <label  class="col-sm-2 control-label">所属分类<em>*</em></label>
          <div class="col-sm-5">
            <select class="form-control" name="cid" id="select">
              <option value="0">-选择分类-</option>

              <?php if($classifyLists): if(is_array($classifyLists)): foreach($classifyLists as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["html"]); echo ($v["name"]); ?></option><?php endforeach; endif; endif; ?>
            
            </select>
            <input type="hidden" value="<?php echo ($video["classid"]); ?>" id="classid">
          </div>
        </div> 

        <div class="form-group" >
          <label for="videoname" class="col-sm-2 control-label">视频名<em>*</em></label>
          <div class="col-sm-5" style="position: relative;">
            <input id="videoname" type="text" name="videoname" class="form-control text" placeholder="请保持在20位之内" value="<?php echo ($video["videoname"]); ?>">
            <div id="videoPosterTestBox">
              <a href="/Video/details/id/<?php echo ($video["vid"]); ?>" target="_blank" id="videoPosterTesta"><img src="<?php echo ($video["videopicurl"]); ?>" alt="" id="videoPosterTest" width="400"></a>
            </div>
          </div>
        </div>
        
        <div class="form-group" >
          <label for="size" class="col-sm-2 control-label">统计<em></em></label>
          <div class="col-sm-10" style="position: relative;">
            <div class="container-fluid col-md-12 p0">
              <div class="input-group col-md-2" style="float: left;">
                <div class="input-group-addon"><span class="glyphicon glyphicon-play-circle"></span></div>
                <input type="text" class="form-control" placeholder="Amount" value="<?php echo ($video["playcount"]); ?>" name="playcount">
              </div>
              <div class="input-group col-md-2" style="float: left;margin-left: 20px;">
                <div class="input-group-addon"><span class="glyphicon glyphicon-comment"></span></div>
                <input type="text" class="form-control" placeholder="Amount" value="<?php echo ($video["comment"]); ?>"  disabled>
              </div>
            </div>
            <div class="container-fluid col-md-12 p0" style="margin-top: 10px;">
              <div class="input-group col-md-2" style="float: left;">
                <div class="input-group-addon"><span class="glyphicon glyphicon-thumbs-up"></span></div>
                <input type="text" class="form-control" placeholder="Amount" value="<?php echo ($video["topcount"]); ?>" name="topcount">
              </div>
              <div class="input-group col-md-2" style="float: left;margin-left: 20px;">
                <div class="input-group-addon"><span class="glyphicon glyphicon-star"></span></div>
                <input type="text" class="form-control" placeholder="Amount" value="<?php echo ($video["keepcount"]); ?>"  disabled>
              </div>              
            </div>
          </div>
        </div>


        <div class="form-group" >
          <label class="col-sm-2 control-label">上传视频封面图<em>(1280X720)</em></label>
          <div class="col-sm-2">
              <input type="file" name="face" id="face">
              <input type="hidden" name="videopicurl" value="<?php echo ($video["videopicurl"]); ?>">
              <input type="hidden" name="videopicurl176" value="<?php echo ($video["videopicurl176"]); ?>">
              <input type="hidden" name="size" id="size" value="<?php echo ($video["size"]); ?>">
              <input type="hidden" name="id" value="<?php echo ($video["vid"]); ?>">
              <input type="hidden" name="videourl" id="videourl" value="<?php echo ($video["videourl"]); ?>">
          </div>
        </div>

        <div class="form-group" >
          <label class="col-sm-2 control-label">视屏上传<em>(*暂时只支持.mp4请保证在3G内)</em></label>
          <div class="col-sm-2">
              <input type="file" name="face" id="face1">
          </div>
        </div> 

        <div class="form-group" >
          <label for="size" class="col-sm-2 control-label">当前视频大小<em></em></label>
          <div class="col-sm-2" style="position: relative;">
            <input id="getsize" type="text" name="size" class="form-control text" value="<?php echo (getSize($video["size"])); ?>" disabled>
          </div>
        </div>

        <div class="form-group" >
          <label for="account" class="col-sm-2 control-label">上传管理员名<em style="color: #ff2200"></em></label>
          <div class="col-sm-10" style="position: relative;">
          <div class="col-md-2 p0">
             <input id="account" type="text" name="account" class="form-control text" value="<?php echo ($video["account"]); ?>" disabled> 
          </div>
          <div class="col-md-5">
            <em style="color: #ff4400;display: block;height: 40px;line-height: 35px;">您修改后会保存<strong>您</strong>的管理员名</em>
          </div>

          </div>
        </div>


        

        <div class="form-group">
          <label for="info" class="col-sm-5 control-label"><em></em></label>
          <div class="col-sm-2">
            <input type="submit" value="更改" class="button button-3d button-primary button-rounded">
          </div>
        </div>          

 </form>



</div>

<!-- 引入尾文件 -->
<!-- 提示效果框 -->
<div id="fade"><span></span></div>










<!-- Jquery 2.1.4 -->
<script type="text/javascript" src="/Public/js/plug-in/j.js"></script>
<!-- 自己的工具类 -->
<script type="text/javascript" src="/Public/js/plug-in/Tool.js"></script>
<!-- bootstrap主要js -->
<script type="text/javascript" src="/Public/js/plug-in/bootstrap.js"></script>
<!-- 引入Upload上传插件 -->
<script type="text/javascript" src="/Public/Uploadify/jquery.uploadify.min.js"></script>
<!-- 本页用到的JS -->
<script type="text/javascript">
/**
 * 默认选择分类
 */
  var nowClassify = $('#classid').val();
  var oSelect     = $('#select>option');
  //循环判断添加默认选中
  for(var i=0;i<oSelect.length;i++){
    if(oSelect.eq(i).val()==nowClassify){
      oSelect.eq(i).attr('selected','selected');
      continue;
    }
  }

/**
   * 封面图上传Uploadify配置
   */
  $('#face').uploadify({
    //引入flash动画
    swf : '/Public/Uploadify/uploadify.swf',
    //php处理地址
    uploader : "<?php echo U('Common/uploadVideoPic');?>",
    width:120,
    height:32,
    //按钮背景图片定义[可选]
    buttonImage:'/Public/Uploadify/browse-btn.png',//貌似很诡异
    //选择文件提示文字
    fileTypeDesc : 'Image File',
    //允许选择的文件类型
    fileTypeExts : '*.jpeg;*.jpg;*.png;*.gif',
    //解决报错 302错误,因为CommonController里面自动验证session存在的函数,导致报302错误,因为不发过去session
    ////发送额外的参数过去
    formData : {
      //var sid = "<?php echo session_id();?>";//获取当前session的值,因为uploadify发过去的数据不带session而CommonController里面又有判断session存不存在的函数,会导致报302错误(没权限)
      'session_id':"<?php echo session_id();?>",
      //这里需要发个VID过去让他能查找到用于删除原数据
      'id':"<?php echo ($video["vid"]); ?>" 
    },
    //回调函数
    ////file 返回文件名 , data返回php的数据 response不知道
    onUploadSuccess:function(file,data,response){
       eval('var data =' + data);//这步是关键,至今不懂为什么.反正不写就是不能用
        if(data.status){

          $('input[name=videopicurl]').val(data.facePath);
          $('input[name=videopicurl176]').val(data.pathmd);
          $('#videoPosterTest').attr({'src':data.facePath});
          $('#videoPosterTestBox').fadeIn();
        }else{
          tishi(data.msg);
        }
    }
  }); 


    /**
   * 视屏上传Uploadify配置
   */
  $('#face1').uploadify({
    //引入flash动画
    swf : '/Public/Uploadify/uploadify.swf',
    //php处理地址
    uploader : "<?php echo U('Common/uploadVideo');?>",
    sizeLimit: '3221225472',//上传文件大小限制
    width:120,
    height:32,
    //按钮背景图片定义[可选]
    buttonImage:'/Public/Uploadify/browse-btn.png',//貌似很诡异
    //选择文件提示文字
    fileTypeDesc : 'Video File',
    //允许选择的文件类型
    fileTypeExts : '*.mp4',
    //解决报错 302错误,因为CommonController里面自动验证session存在的函数,导致报302错误,因为不发过去session
    ////发送额外的参数过去
    formData : {
      //var sid = "<?php echo session_id();?>";//获取当前session的值,因为uploadify发过去的数据不带session而CommonController里面又有判断session存不存在的函数,会导致报302错误(没权限)
      'session_id':"<?php echo session_id();?>",
      //这里需要发个VID过去让他能查找到用于删除原数据
      'id':"<?php echo ($video["vid"]); ?>"  
    },
    //回调函数
    ////file 返回文件名 , data返回php的数据 response不知道
    onUploadSuccess:function(file,data,response){
       eval('var data =' + data);//这步是关键,至今不懂为什么.反正不写就是不能用
        if(data.status){
          //得到地址以后 添加给表单Input
          tishi('上传成功');
          $('#videourl').val(data.msg);
          $('#size').val(data.size);
          $('#getsize').val(data.getsize);
        }else{
          tishi(data.msg);
        }
    }
  }); 



</script>

</body>
</html>