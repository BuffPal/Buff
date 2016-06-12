/**
 * 主要用来给top里面的nav四个A标签添加效果(当前画面是那一个,对应的变亮)
 * @return {[type]} [description]
 */
function admin_top_nav(j){
  for(var i = 1;i<5;i++){
    document.getElementById('nav'+i).style.backgroundColor = '#F36C72';
    document.getElementById('nav'+i).style.color = '#1B1A5E';
  }
 var a = j;
  document.getElementById('nav'+a).style.backgroundColor = '#1B0EEA';
  document.getElementById('nav'+a).style.color = '#ddd';
}