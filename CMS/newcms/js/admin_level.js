window.onload = function () {
  var oStrong = document.getElementById('strong');
  var oOl     = document.getElementsByTagName('ol');
  var oA      = oOl[0].getElementsByTagName('a');
  for(var i = 0;i<oA.length;i++){
    oA[i].className = null;
    if(oA[i].text == oStrong.innerHTML){
      oA[i].className = 'selected';
    }
  }
};

//验证等级表单
function checkForm() {
	var fm = document.add;
	if (fm.level_name.value == '' || fm.level_name.value.length < 2 || fm.level_name.value.length > 20) {
		alert('警告：等级名称不得为空并且不得小于两位并且不得大于20位来自JS');
		fm.level_name.focus();
		return false;
	}
	if (fm.level_info.value.length > 200) {
		alert('警告：等级描述不得大于200位来自JS');
		fm.level_info.focus();
		return false;
	}
	return true;
}


function checkFormUpdate(){
    var fm = document.checkFormUpdate;
    if (fm.level_name.value == '' || fm.level_name.value.length < 2 || fm.level_name.value.length > 20) {
      alert('警告：等级名称不得为空并且不得小于两位并且不得大于20位来自JS');
      fm.level_name.focus();
      return false;
    }
    if (fm.level_info.value.length > 200) {
      alert('警告：等级描述不得大于200位来自JS');
      fm.level_info.focus();
      return false;
    }
    return true;
}







