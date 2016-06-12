<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <style type="text/css">
    #videoPosterTest {
        display: block;
        border-radius: 3px;
        border: 2px solid #fff;
        box-shadow: 0px 0px 10px #333;
        transition: .5s;
    }
    
    #videoPosterTesta {
        display: block;
        position: absolute;
        left: 120%;
        top: -20px;
        z-index: 50;
    }
    
    #videoPosterTesta:hover >img {
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
                <a href="#">音乐管理</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo U('index');?>">音乐列表</a> <span class="divider">/</span>
            </li>
            <li class="active">
                音乐修改
            </li>
        </ul>
    </div>
    <div class="container">
        <h1 class="container-fluid col-md-12 text-center">音乐修改</h1>
        <p>　</p>
        <form action="<?php echo U('op');?>" method="post" class="form-horizontal col-md-12">
            <div class="form-group">
                <label class="col-sm-2 control-label">所属栏目<em>*</em></label>
                <div class="col-sm-5">
                    <select class="form-control" name="cid" id="select">
                        <option value="''">您必须选择一个栏目~!</option>
                        <?php if($classifyLists): if(is_array($classifyLists)): foreach($classifyLists as $key=>$v): ?><optgroup label="<?php echo ($v["name"]); ?>">
                                    <?php if(is_array($v['child'])): foreach($v['child'] as $key=>$value): ?><option value="<?php echo ($value["id"]); ?>"><?php echo ($value["name"]); ?></option><?php endforeach; endif; ?>
                                </optgroup><?php endforeach; endif; ?>
                            <?php else: ?>
                            <option value="0" id="geng"><a href="#">暂没有栏目点击添加</a></option><?php endif; ?>
                    </select>
                    <input type="hidden" value="<?php echo ($music["classid"]); ?>" id="classid">
                </div>
            </div>
            <div class="form-group">
                <label for="musicname" class="col-sm-2 control-label">音乐名<em>*</em></label>
                <div class="col-sm-5" style="position: relative;">
                    <input id="musicname" type="text" name="musicname" class="form-control text" placeholder="请保持在20位之内" value="<?php echo ($music["musicname"]); ?>">
                    <div id="videoPosterTestBox">
                        <a href="/Video/details/id/<?php echo ($video["vid"]); ?>" target="_blank" id="videoPosterTesta"><img src="<?php echo ($music["musicbgurl"]); ?>" alt="" id="videoPosterTest" width="200"></a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="author" class="col-sm-2 control-label">作者名<em>*</em></label>
                <div class="col-sm-3" style="position: relative;">
                    <input id="author" type="text" name="author" class="form-control text" placeholder="请保持在20位之内" value="<?php echo ($music["author"]); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="size" class="col-sm-2 control-label">统计<em></em></label>
                <div class="col-sm-10" style="position: relative;">
                    <div class="container-fluid col-md-12 p0">
                        <div class="input-group col-md-2" style="float: left;">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-play-circle"></span></div>
                            <input type="text" class="form-control" placeholder="Amount" value="<?php echo ($music["playcount"]); ?>" name="playcount">
                        </div>
                        <div class="input-group col-md-2" style="float: left;margin-left: 20px;">
                            <div class="input-group-addon"><span class="glyphicon glyphicon-star"></span></div>
                            <input type="text" class="form-control" placeholder="Amount" value="<?php echo ($music["keepcount"]); ?>" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">修改音乐背景<em>(200X204)</em></label>
                <div class="col-sm-2">
                    <input type="file" name="face" id="face">
                    <input type="hidden" name="musicbgurl" value="<?php echo ($music["musicbgurl"]); ?>">
                    <input type="hidden" name="size" id="size" value="<?php echo ($music["size"]); ?>">
                    <input type="hidden" name="id" value="<?php echo ($music["mid"]); ?>">
                    <input type="hidden" name="musicurl" id="musicurl" value="<?php echo ($music["musicurl"]); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">重新上传音乐<em>(*暂时只支持.mp3请保证在10M内)</em></label>
                <div class="col-sm-2">
                    <input type="file" name="face" id="face1">
                </div>
            </div>
            <div class="form-group">
                <label for="size" class="col-sm-2 control-label">当前音乐大小<em></em></label>
                <div class="col-sm-2" style="position: relative;">
                    <input id="getsize" type="text" name="size" class="form-control text" value="<?php echo (getSize($music["size"])); ?>" disabled>
                </div>
            </div>
            <div class="form-group">
                <label for="account" class="col-sm-2 control-label">上传管理员名<em style="color: #ff2200"></em></label>
                <div class="col-sm-10" style="position: relative;">
                    <div class="col-md-2 p0">
                        <input id="account" type="text" name="account" class="form-control text" value="<?php echo ($music["account"]); ?>" disabled>
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
    var oSelect = $('#select option');
    //循环判断添加默认选中
    for (var i = 0; i < oSelect.length; i++) {
        if (oSelect.eq(i).val() == nowClassify) {
            oSelect.eq(i).attr('selected', 'selected');
            continue;
        }
    }

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
        fileTypeDesc: 'Image File',
        //允许选择的文件类型
        fileTypeExts: '*.jpeg;*.jpg;*.png;*.gif',
        //解决报错 302错误,因为CommonController里面自动验证session存在的函数,导致报302错误,因为不发过去session
        ////发送额外的参数过去
        formData: {
            //var sid = "<?php echo session_id();?>";//获取当前session的值,因为uploadify发过去的数据不带session而CommonController里面又有判断session存不存在的函数,会导致报302错误(没权限)
            'session_id': "<?php echo session_id();?>",
            //这里需要发个VID过去让他能查找到用于删除原数据
            'id': "<?php echo ($music["mid"]); ?>"
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
            'session_id': "<?php echo session_id();?>",
            //这里需要发个VID过去让他能查找到用于删除原数据
            'id': "<?php echo ($music["mid"]); ?>"
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
                $('#getsize').val(data.getsize);
            } else {
                tishi(data.msg);
            }
        }
    });
    </script>
</body>

</html>