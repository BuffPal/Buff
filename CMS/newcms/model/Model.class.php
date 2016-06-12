<?php 
class Model{
//执行多条sql语句
public function multi($sql){
  $db = DB::getDB();
  $db->multi_query($sql);
  DB::unDB($_result,$db);
  return true;
}

//查找一条管理员
protected function one($_sql){
  $_db = DB::getDB();
  $result = $_db->query($_sql);
  $objs = $result->fetch_object();
  DB::unDB($result,$_db);
  return Tool::htmlString($objs);
}

//查找所有管理员
protected function all($_sql){
  $_db = DB::getDB();
  $_result = $_db->query($_sql);
  $html = array();
  while(!!$_objs = $_result->fetch_object()){
    $html[] = $_objs;
  };
  DB::unDB($_result,$_db);
  return Tool::htmlString($html);                 //这个函数是转义html的
}

//增修删模型
protected function aud($_sql){
  $_db = DB::getDB();
  $_db->query($_sql);
  $_return = $_db->affected_rows;
  DB::unDB($result,$_db);
  return $_return;
}

//查找总记录模型
protected function total($_sql){
    $_db = DB::getDB();
    $_result = $_db->query($_sql);
    $_total = $_result->fetch_row();
    DB::unDB($_result,$_db);
    return $_total[0];
}


  //用来获得sort 对应 的 ID 值,使他们保持一致 在207 15分钟开始           获取下一个增值ID
  protected function nextId($table){
    $sql = "SHOW TABLE STATUS LIKE '$table'";
    $obj = $this->one($sql);
    return $obj->Auto_increment;
  }

//查找所有管理员
protected function arrayAll($_sql){
  $_db = DB::getDB();
  $_result = $_db->query($_sql);
  $html = array();
  while(!!$_objs = $_result->fetch_assoc()){
    $html[] = $_objs;
  };
  DB::unDB($_result,$_db);
  return Tool::htmlString($html);                 //这个函数是转义html的
}


}
 ?>