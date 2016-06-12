window.onload = function (){
  /**
   * 子菜单 点击切换class
   * @type {[type]}
   */
  var level = document.getElementById('upData_level');
  var options = document.getElementsByTagName('option');
  if(level){
    for(var i = 0;i<options.length;i++){
      if(level.value == options[i].value){
        options[i].setAttribute('selected','selected');
      }
    }
  }
  var oStrong = document.getElementById('strong');
  var oOl     = document.getElementsByTagName('ol');
  var oA      = oOl[0].getElementsByTagName('a');
  for(var i = 0;i<oA.length;i++){
    oA[i].className = null;
    if(oA[i].text == oStrong.innerHTML){
      oA[i].className = 'selected';
    }
  }
  ///////////////////////////////以上结束////////////////////
}

//验证Manage update
  function checkUpdateForm(){
    var fm = document.update;
    if(fm.admin_pass.value != ''){
      if(fm.admin_pass.value.length < 6){
        alert("ERROR:密码不能小于 6 位");
        fm.admin_pass.focus();
        return false;
      }
    }
    return true
  }

//验证Manage add
  function checkAddForm(){
       var fm = document.add;
       if(fm.admin_user.value == '' || fm.admin_user.value.length < 2 || fm.admin_user.value.length >20){
        alert('ERROR:用户名必须在 2 到 20 位之间 来自JS');
        fm.admin_user.focus();
        return false;
       }
       if(fm.admin_pass.vlaue == '' || fm.admin_pass.value.length <6){
        alert('ERROR:密码必须大于 6 位 来自JS');
        fm.admin_pass.focus();
        return false;
       }
       if(fm.admin_pass.value != fm.admin_notpass.value){
        alert('ERROR:两次输入密码不相同 来自JS');
        fm.admin_notpass.focus();
        return false;
       }
       return true;
     }