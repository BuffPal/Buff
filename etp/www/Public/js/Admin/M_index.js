/**
 * 后台视频列表专用
 */
$(function(){
var nowClassify = $('input[name=classifyId]').val();
var oSelect     = $('#classifySelect option');
//循环判断添加默认选中
for(var i=0;i<oSelect.length;i++){
  if(oSelect.eq(i).val()==nowClassify){
    oSelect.eq(i).attr('selected','selected');
    continue;
  }
}

/**
 * 点击删除,AJAX删除
 */
$('a.delete').on('click',function(){
  if(confirm('确认删除么')){
    var id = $(this).attr('mid');
    var oTr = $(this).closest('tr');
    //后台ajax删除 
    $.post(deleteMusicUrl,{'id':id},function(data){
      if(data.status){
        tishi(data.msg);
        oTr.slideUp("fast");
      }else{
        tishi(data.msg);
      }
    },'json');
  }else{
    return false;
  }
});


});