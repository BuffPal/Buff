<?php 
/**
 * 数据库连接类
 */
class DB{

  static public function getDB(){
    $_db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    if(mysqli_connect_errno()){
      exit('ERROR:数据库连接失败'.mysqli_connect_error());
    }
    $_db->set_charset('utf8');
    return $_db;
  }

  static public function unDB(&$_result,&$_db){
    if(is_object($_result)){
      $_result->free();
      $_result = null;
    }
    if(is_object($_db)){
      $_db->close();
      $_db = null;
    } 
  }
}
 ?>