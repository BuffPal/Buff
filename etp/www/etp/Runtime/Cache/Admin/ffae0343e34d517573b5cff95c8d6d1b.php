<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<style type="text/css">
#videoPosterTestBox {
    position: absolute;
    top: 0;
    left: 120%;
    display: none;
}

#videoPosterTest {
    width: 200px;
    height: 204px;
    border-radius: 3px;
    border: 2px solid #fff;
    box-shadow: 0px 0px 10px #333;
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
            <li class="active">
                上传音乐
            </li>
        </ul>
    </div>
    <div class="container">
        <h1 class="text-center">上传音乐</h1>
    </div>
    <form action="<?php echo U('add');?>" method="post" class="form-horizontal col-md-12">
        <div class="form-group">
            <label class="col-sm-5 control-label">栏目选择<em>*</em></label>
            <input type="hidden" id="getId" value="<?php echo ($getId); ?>">
            <div class="col-sm-2">
                <select class="form-control" name="cid" id="classifySelect">
                    <option value="''">请选择您要上传的栏目</option>
                    <?php if($classifyLists): if(is_array($classifyLists)): foreach($classifyLists as $key=>$v): ?><optgroup label="<?php echo ($v["name"]); ?>">
                                <?php if(is_array($v['child'])): foreach($v['child'] as $key=>$value): ?><option value="<?php echo ($value["id"]); ?>"><?php echo ($value["name"]); ?></option><?php endforeach; endif; ?>
                            </optgroup><?php endforeach; endif; ?>
                        <?php else: ?>
                        <option value="0" id="geng"><a href="#">暂没有栏目点击添加</a></option><?php endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="musicname" class="col-sm-5 control-label">音乐名<em>*</em></label>
            <div class="col-sm-2" style="position: relative;">
                <input id="musicname" type="text" name="musicname" class="form-control text" placeholder="请保持在20位之内">
                <div id="videoPosterTestBox">
                    <img src="" alt="" id="videoPosterTest">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="author" class="col-sm-5 control-label">歌手<em>*</em></label>
            <div class="col-sm-2" style="position: relative;">
                <input id="author" type="text" name="author" class="form-control text" placeholder="请保持在20位之内">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">音乐封面图　　标准200x204<em>*</em></label>
            <div class="col-sm-2">
                <input type="file" name="face" id="face">
                <input type="hidden" name="musicbgurl" id="pic">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">音乐上传(只支持.mp3)<em>*</em></label>
            <div class="col-sm-2">
                <input type="file" name="face" id="face1">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-5 control-label">音乐地址:<em>:</em></label>
            <div class="col-sm-2">
                <input type="text" name="musicurl" id="musicurl" readonly class="form-control text" laceholder="上传后自动添加">
                <input type="hidden" name="size" id="size">
            </div>
        </div>
        <div class="form-group">
            <label for="info" class="col-sm-5 control-label"><em></em></label>
            <div class="col-sm-2">
                <input type="submit" value="添加" class="button button-3d button-primary button-rounded" id="videoSBT">
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
     * 封面图上传Uploadify配置
     */
    $('#face').uploadify({
        //引入flash动画
        swf: '/Public/Uploadify/uploadify.swf',
        //php处理地址
        uploader: "<?php echo U('Common/uploadMusicBg');?>",
        width: 120,
        height: 32,
        //按钮背景图片定义[可选]
        buttonImage: '/Public/Uploadify/browse-btn.png', //貌似很诡异
        //选择文件提示文字
        fileTypeDesc: 'Images File',
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
                $('input[name=musicbgurl]').val(data.facePath);
                $('#videoPosterTest').attr({
                    'src': data.facePath
                });
                $('#videoPosterTestBox').fadeIn();
            } else {
                tishi(data.msg);
            }
        }
    });


    /**
     * 视屏上传Uploadify配置
     */
    $('#face1').uploadify({
        //引入flash动画
        swf: '/Public/Uploadify/uploadify.swf',
        //php处理地址
        uploader: "<?php echo U('Common/uploadMusic');?>",
        sizeLimit: '10485760', //上传文件大小限制
        width: 120,
        height: 32,
        //按钮背景图片定义[可选]
        buttonImage: '/Public/Uploadify/browse-btn.png', //貌似很诡异
        //选择文件提示文字
        fileTypeDesc: 'Music File',
        //允许选择的文件类型
        fileTypeExts: '*.mp3',
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
                //得到地址以后 添加给表单Input
                tishi('上传成功');
                $('#musicurl').val(data.msg);
                $('#size').val(data.size);
            } else {
                tishi(data.msg);
            }
        }
    });

    //上传视频按钮点击判断
       $('#videoSBT').on('click', function() {
           //栏目判断
           var classify = $('select[name=cid]').val();
           //视频名判断
           var musicname = $('#musicname').val();
           //歌手判断
           var author = $('#author').val();
           //封面图判断
           var musicbgurl = $('input[name=musicbgurl]').val();
           //视频地址判断
           var musicurl = $('input[name=musicurl]').val();
           if (isNaN(classify)) {
               tishi('必须选择栏目');
               return false;
           }
           if ($.trim(musicname) == '') {
               tishi('请填写音乐名称');
               return false;
           }
           if ($.trim(author) == '') {
               tishi('请填写歌手名称');
               return false;
           }
           if ($.trim(musicbgurl) == '') {
               tishi('请上传本音乐的封面图');
               return false;
           }
           if ($.trim(musicurl) == '') {
               tishi('请您上传音乐~~~~~');
               return false
           };
       })
    </script>
</body>

</html>