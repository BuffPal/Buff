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
