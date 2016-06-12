<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
<style type="text/css">
  tbody tr:hover >td{
    background: #DEF0FE;
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
<div class="col-md-12" style="padding: 10px 40% 10px 40%;">
  <a href="<?php echo U('addClassify');?>" class="button button-3d button-primary button-rounded center-bolck">添加根类</a>
</div>
<table class="table table-hover table-condensed col-md-12">
  <thead>
    <tr>
      <th style="width: 5%">编号</th>
      <th style="width: 85%">类名</th>
      <th style="width: 10%">操作</th>
    </tr>
  </thead>
  <tbody>

  <?php if($classifyLists): if(is_array($classifyLists)): foreach($classifyLists as $key=>$v): ?><tr>
        <td><?php echo ($key+1); ?></td>
        <td><?php echo ($v["html"]); echo ($v["name"]); ?></td>
        <td>
          <a href="<?php echo U('addClassify',array('id'=>$v['id'],'name'=>$v['name']));?>">[添加]</a> | 
          <a href="<?php echo U('reviseClassify',array('id'=>$v['id']));?>">[修改]</a> | 
          <a href="#" class="delete" cid="<?php echo ($v["id"]); ?>">[删除]</a>
        </td>
      </tr><?php endforeach; endif; ?>
  <?php else: ?>
        <tr>
        <td></td>
        <td>暂时木有数据,<a href="3">点我添加</a></td>
        <td>
        </td>
      </tr><?php endif; ?>


  </tbody>
</table>

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
   * 点击删除删除他
   */
  $('a.delete').on('click',function(){
    if(confirm('确认删除么')){
      var id  = $(this).attr('cid');
      var oTr = $(this).closest('tr');
      //后台ajax删除 
      $.post("<?php echo U('deleteClassify');?>",{'id':id},function(data){
        if(data.status){
          tishi(data.msg);
          oTr.slideUp("fast");
        }else{
          alert(data.msg);
        }
      },'json');
    }else{
      return false;
    }
  })

</script>
</body>
</html>