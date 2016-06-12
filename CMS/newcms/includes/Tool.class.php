<?php 
/**
 * 小工具 :)
 */
class Tool{

  //弹窗跳转
  static public function alertLocation($info,$url){
    if(!empty($info)){
      echo "<script>alert('$info');location.href='$url';</script>";
      exit();
    }else{
      header('Location:'.$url);
      exit();
    }
  }

  //弹窗返回
  static public function alertBack($info){
    echo "<script>alert('$info');history.back();</script>";
    exit();
  }

  //清理session
  static public function unSession(){
    if(session_start()){//判断session是否开启,没有开启就不执行(不然会报错)
      session_destroy();
    }
  }

  //显示html过滤
  static public function htmlString($data){
    if(is_array($data)){
      foreach($data as $key => $value){                      //递归实现过滤  对象 对象数组 数组 字符串 204课
        $str[$key] = @Tool::htmlString($value);
      }
    }elseif(is_object($data)){
      foreach($data as $key => $value){                      //递归实现过滤  对象 对象数组 数组 字符串 204课
        @$str->$key = @Tool::htmlString($value);
      }
    }else{
      $str = htmlspecialchars($data);
    }
    return $str;
  }

  //mysql 注入过滤
  static public function mysqlString($data){
    return !GPC ? @mysql_real_escape_string($data) : $data;
  }

  //无限极分类 
  static Public function unlimitedForLayer($cate,$pid=0){
    $arr =array();
    foreach ($cate as $v) {
     if($v['pid']==$pid){
      $v['child']=self::unlimitedForLayer($cate,$v['id']);
      $arr[]=$v;
     }
    }
    return $arr;
  }

  
}
 ?>

