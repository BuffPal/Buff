<?php 
/**
 * 格式化打印数组
 */
  function p($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
  }

/**
 * 检测验证码是否正确
 * @param  [String] $code [输入的验证码]
 * @return [Boole]       [true为通过 false为不通过]
 */
  function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
  }

/**
 * 异位或加密字符串
 * @param  [String]  $value [需要加密的字符串]
 * @param  [integer] $type  [加密解密（0：加密，1：解密）]
 * @return [String]         [加密或解密后的字符串]
 */
function encryption ($value,$type = 0){
    $key = md5(C('ENCTYPTION_KEY')); //md5秘钥   C函数是读取配置函数
    if(!$type){
        return str_replace('=','',base64_encode($value ^ $key));//这里是异位或运算,计算机底层知识
    }
    $value = base64_decode($value);
    return $value ^ $key;
}

/**
 * 输出utf-8
 */
function UTF8(){
  return header('Content-Type:text/html;Charset=UTF-8');
}

/**
 * 二维数组转换为一维数组
 * @param [Arr] $arr [需要转换的二维数组]
 * @param [Str] $name [指定的数据名]
 * @return [Arr]         [返回一维数组]
 */
function TwoArrToOneArr($arr,$name){
  if($arr){
    foreach($arr as $k=>$v){
      $arr[$k] = $v[$name];
    }
  }
  return $arr;
}
/**
 * 在指定位置插入字符串
 * @param  [type] $str    [字符串]
 * @param  [type] $i      [位置]
 * @param  [type] $substr [插入字符]
 * @return [type]         [新字符串]
 */
function str_insert($str, $i, $substr){
  for($j=0; $j<$i; $j++){
      $startstr .= $str[$j];
  }
  for ($j=$i; $j<strlen($str); $j++){
      $laststr .= $str[$j];
  }
  $str = ($startstr . $substr . $laststr);
      return $str;
} 


/**
 * [将时间戳,转换为 多久前发布 的格式]
 * @param  [string] $time [时间戳]
 * @return [string]       [string]
 */
function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}

/**
 * [将数组的时间戳转换为 多久前发布]
 * @param  [array] $obj     [需要转换的数组]
 * @param  [content] $content [需要转换的数据]
 * @return [array]          [返回的数据,新增的名字 为 time]
 */
function stringDate($array,$content){
   if(isset($array)){
      foreach($array as $k=>$v){// 把时间戳转换下
        if($v[$content]){//解决 有些$content为空的时候报错
          $array[$k]['timeStr'] = format_date($v[$content]);//这里要用 $k
          $array[$k][$content] = date("Y-m-d H:i:s",$v[$content]);
        }
      }
    }else{
      $array['msg'] = '失败';
    }
    return $array;
}


/**
 * 替换微博内容的URLI的地址 @用户与表情
 * @param  [string] $content [需要处理的字符串]
 * @param  [布尔] $a [时候需要转换A连接]
 * @return [type]          [description]
 */
function replace_weibo($content,$a = true){//这个是模板里面调用的 所以就不能用&
    if(empty($content)) return $content;
    if($a){
      $preg = '/(?:http:\/\/)?([\w.]+[\w\/]*\.[\w.]+[\w\/]*\??[\w=\&\+\%]*)/is';
      $content = preg_replace($preg , '<a href="http://\\1" target="_blank">\\1</a>',$content);
      
      //给用户 @ 添加<a>连接
      $preg = '/@(\S+)\s/is';//\S匹配不为空格的
      $content = preg_replace($preg, '<a href="' . __APP__ . '/Home/Index/\\1" target="_blank">@\\1 </a>', $content);
    }
    //载入表情包数组文件
    $phiz = include './Public/data/phiz.php';
    //提取微博内容中的表情文字
    $preg = '/\[(\S+?)\]/is';
    preg_match_all($preg,$content,$arr);//获取匹配到的数据 为数组 全部都匹配
    if(!empty($arr[1])){//如果为假就代表着用户没有输入表情
      foreach($arr[1] as $k=>$v){
        $name = array_search($v, $phiz);// 查找数组里面有没有键值为$v的 如果有返回该键值的键名 没有着false
        if($name){
          $content = str_replace($arr[0][$k],'<img src="'.__ROOT__.'/Public/images/phiz/'.$name.'.gif" title="'.$v.'">',$content);
        }
      }
    }
    return $content;
}

/**
 *  裁剪字符串长度
 * @param  [type] $string [description]
 * @param  [type] $length [description]
 * @return [type]         [description]
 */
function omitString($string,$length){
  if($string){
    if(mb_strlen($string,'utf-8') > $length){
      $string = mb_substr($string, 0,$length,'utf-8')."……";
    }
  }
  return $string;
}


 ?>