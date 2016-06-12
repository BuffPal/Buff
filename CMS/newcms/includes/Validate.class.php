<?php 
  /**
   * 验证类
   */
  class Validate{
    //是否为空
    static public function checkNull($data){
      if(trim($data) =='') return true;
    
        return false;
      
    }

    //长度是否合法
    static public function checkLength($data,$length,$flag){
      if($flag == 'min'){
          if(mb_strlen(trim($data),'utf-8') < $length) return true;
          return false;
      }elseif($flag =='max'){
          if(mb_strlen(trim($data),'utf-8') > $length) return true;
          return false;
      }elseif($flag == 'equals'){
        if(mb_strlen(trim($data),'utf-8') != $length) return true;
      }else{
        Tool::alertBack('ERROR: checkLength()第三个参数错误 min/max');
      } 
    }

    //数据是否一致
    static public function checkEquals($data,$otherdata){
      if(trim($data) != trim($otherdata)) return true;
      return false;
    }
    
    //session验证
    static public function checkSession(){
      if(!isset($_SESSION['admin'])) Tool::alertLocation('您还未登录！','admin_login.php');
    }

  }
 ?>