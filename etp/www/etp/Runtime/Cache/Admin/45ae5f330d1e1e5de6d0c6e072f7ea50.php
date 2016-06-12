<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<style type="text/css">
#videoPosterTestBox {
    position: absolute;
    width: 44px;
    height: 44px;
    top: 120%;
    left: 50%;
    border: 2px solid #fff;
    border-radius: 3px;
    box-shadow: 0px 0px 10px #888;
    display: none;
}
</style>

<body>
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
                <a href="#">音乐管理</a> <span class="divider">/</span>
            </li>
            <?php if($name): ?><li>
                    <a href="<?php echo U('lists');?>">音乐栏目</a> <span class="divider">/</span>
                </li><?php endif; ?>
            <li class="active">
                添加栏目
            </li>
        </ul>
    </div>
    <div class="container">
        <h1 class="text-center">添加栏目</h1>
    </div>
    <form action="<?php echo U('addClassify');?>" method="post" class="form-horizontal col-md-12">
        <div class="form-group">
            <label class="col-sm-5 control-label">选择父栏目(只支持两级)<em>*</em></label>
            <input type="hidden" id="getId" value="<?php echo ($getId); ?>">
            <div class="col-sm-2">
                <select class="form-control" name="fid" id="classifySelect">
                    <option value="''">----请选择栏目----</option>
                    <option value="0" id="geng">　根栏目</option>
                    <?php if($classifyLists): if(is_array($classifyLists)): foreach($classifyLists as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["html"]); echo ($v["name"]); ?></option><?php endforeach; endif; endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-5 control-label">栏目名<em>*</em></label>
            <div class="col-sm-2" style="position: relative;">
                <input id="name" type="text" name="name" class="form-control text" placeholder="请保持在20位之内">
                <div id="videoPosterTestBox">
                    <img src="" alt="" id="videoPosterTest">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">标准40X40<em>*</em></label>
            <div class="col-sm-2">
                <input type="file" name="face" id="face">
                <input type="hidden" name="faceurl" id="pic">
            </div>
        </div>
        <div class="form-group">
            <label for="info" class="col-sm-5 control-label"><em></em></label>
            <div class="col-sm-2">
                <input type="submit" value="添加" class="button button-3d button-primary button-rounded">
            </div>
        </div>
    </form>
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
    <script type="text/javascript">
    /**
     * 默认选择栏目
     */
    var getId = $('#getId').val();
    var oOption = $('#classifySelect>option');
    if (getId != '根' && typeof(getId) != "undefined") {
        for (var i = 0; i < oOption.length; i++) {
            if (oOption.eq(i).val() == getId) {
                oOption.eq(i).attr('selected', 'selected');
            }
        }
    } else {
        $('#geng').attr('selected', 'selected');
    }
    /**
     * 发布判断
     */
    $('input[type=submit]').click(function() {
        var name = $('input[name=name]').val();
        var classify = $('#classifySelect').val();
        var pic = $('#pic').val();
        if (classify == '') {
            tishi('请选择父类');
            return false;
        }
        if ($.trim(name) == '') {
            tishi('请输入栏目名~');
            return false;
        }
        if (pic == '') {
            tishi('请上传栏目图像~');
            return false;
        }
    });
    /**
     * uploads上传插件配置
     */
    $('#face').uploadify({
        //引入flash动画
        swf: '/Public/Uploadify/uploadify.swf',
        //php处理地址
        uploader: "<?php echo U('Common/uploadMusicPoster');?>",
        width: 120,
        height: 32,
        //按钮背景图片定义[可选]
        buttonImage: '/Public/Uploadify/browse-btn.png', //貌似很诡异
        //选择文件提示文字
        fileTypeDesc: 'Image File',
        //允许选择的文件类型
        fileTypeExts: '*.jpeg;*.jpg;*.png;*.gif',
        //解决报错 302错误,因为CommonController里面自动验证session存在的函数,导致报302错误,因为不发过去session
        ////发送额外的参数过去
        formData: {
            //var sid = "<?php echo session_id();?>";//获取当前session的值,因为uploadify发过去的数据不带session而CommonController里面又有判断session存不存在的函数,会导致报302错误(没权限)
            'session_id': "<?php echo session_id();?>"
        },
        //回调函数
        ////file 返回文件名 , data返回php的数据 response不知道
        onUploadSuccess: function(file, data, response) {
            eval('var data =' + data); //这步是关键,至今不懂为什么.反正不写就是不能用
            if (data.status) {
                $('input[name=faceurl]').val(data.facePath);
                $('#videoPosterTest').attr({
                    'src': data.facePath
                });
                $('#videoPosterTestBox').fadeIn();
            } else {
                tishi(data.msg);
            }
        }
    });
    </script>
</body>

</html>