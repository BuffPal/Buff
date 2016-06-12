/**
 * 验证的登录
 */
function checkLogin(){
  var fm = document.getElementById('admin_login');
  if(fm.code.value.length != 4 ){
    alert('验证码错误@');
    return false;
  }else if(fm.admin_user.value == '' || fm.admin_user.value.length < 2 || fm.admin_user.value.length > 20 || fm.admin_pass < 6){
    alert('账号或密码错误@');
    return false;
  }
  return true;
}