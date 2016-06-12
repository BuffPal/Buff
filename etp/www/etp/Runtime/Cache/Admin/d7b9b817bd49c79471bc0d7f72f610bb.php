<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
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
<style>
tr>td:nth-child(5)>span{
  display: inline-block;
  width:50%;
  float: left;
  padding: 3px 0;
  font-weight: bold;
  font-size: 16px;
  color: #888;
}
tr>th{
  text-align: center;
}
tr>td{
  text-align: center;
  font-size: 16px;
  font-family: '微软雅黑';
}

</style>
<div class="container-fulid">
  <ul class="breadcrumb">
    <li>
      <a href="#">视频管理</a> <span class="divider">/</span>
    </li>

    <li class="active">
      视频列表
    </li>
  </ul>
</div>
<div class="container-fluid">
  <!-- 分类查询 -->
  <form action="<?php echo U('index');?>" class="form-horizontal col-md-6" method="post">
        <div class="form-group" >
          <label  class="col-sm-5 control-label">分类查询<em></em></label>
          <div class="col-sm-5">
            <select class="form-control" name="cid" id="classifySelect">
              <option value="0">-默认全部-</option>

              <?php if($classifyLists): if(is_array($classifyLists)): foreach($classifyLists as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["html"]); echo ($v["name"]); ?></option><?php endforeach; endif; endif; ?>

            </select>
            <input type="hidden" name="type" value="classify">
            <input type="hidden" name="classifyId" value="<?php echo ($classifyId); ?>">

          </div>
          <input type="submit" value="查看" class="button button-3d button-primary button-rounded button-small">
        </div>   
  </form>
  <!-- 关键字查询 -->
  <form action="<?php echo U('index');?>"  class="form-horizontal col-md-6" method="post">
        <div class="form-group" >
          <label  class="col-sm-2 control-label">搜索<em></em></label>
          <div class="col-sm-5">
            <input type="text" name="keyword" class="form-control text" value="<?php echo ($keyword); ?>">
            <input type="hidden" name="type" value="keyword">
          </div>
          <input type="submit" value="搜索" class="button button-3d button-primary button-rounded button-small">
        </div>   
  </form>
</div>
<p>　</p>
<div class="container-fulid">
  <table class="table table-hover table-condensed col-md-12">
    <thead>
      <th style="width: 5%">编号</th>
      <th style="width: 10%">缩略图</th>
      <th style="width: 15%">视频名</th>
      <th style="width: 10%">视频大小</th>
      <th style="width: 15%">统计数据</th>
      <th style="width: 10%">所属栏目</th>
      <th style="width: 10%">发布者</th>
      <th style="width: 10%">上传时间</th>
      <th style="width: 15%">操作</th>
    </thead>
    <tbody>
      <?php if($resultAll): if(is_array($resultAll)): foreach($resultAll as $key=>$v): ?><tr>
            <td><?php echo ($key+1); ?></td>
            <td><img src="<?php echo ($v["videopicurl176"]); ?>" width="120"></td>
            <td><?php echo (str_replace($keyword,'<span style="color:orangered;">'.$keyword.'</span>',$v["videoname"])); ?></td>
            <td><?php echo (getSize($v["size"])); ?></td>
            <td>
              <span class="glyphicon glyphicon-play-circle"> <?php echo (getNum($v["playcount"])); ?></span>
              <span class="glyphicon glyphicon-comment"> <?php echo ($v["comment"]); ?></span>
              <span class="glyphicon glyphicon-star"> <?php echo ($v["keepcount"]); ?></span>
              <span class="glyphicon glyphicon-thumbs-up"> <?php echo ($v["topcount"]); ?></span>
            </td>
            <td><a href="<?php echo ($v["classid"]); ?>"><?php echo ($v["name"]); ?></a></td>
            <td><?php echo ($v["account"]); ?></td>
            <td><?php echo (date('Y-m-d H:i:s',$v["uploadtime"])); ?></td>
            <td>
              <a href="/Video/details/id/<?php echo ($v["vid"]); ?>" target="_blank">[查看]</a> |
              <a href="<?php echo U('op',array('id'=>$v['vid']));?>">[修改]</a> |
              <a href="#" vid='<?php echo ($v["vid"]); ?>' class="delete">[删除]</a>
            </td>
          </tr><?php endforeach; endif; ?>

      <?php else: ?>
        <tr>
          <td></td>
          <td>没</td>
          <td></td>
          <td>有</td>
          <td></td>
          <td>数</td>
          <td></td>
          <td>据</td>
          <td></td>
        </tr><?php endif; ?>

    </tbody>
  </table>
<div class="pages"><?php echo ($page); ?></div>
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
<script type="text/javascript">
  var deleteVideoUrl = "<?php echo U(deleteVideo);?>";//AJAX删除视频处理地址
</script>
<script type="text/javascript" src="/Public/js/Admin/V_index.js"></script>

</body>
</html>