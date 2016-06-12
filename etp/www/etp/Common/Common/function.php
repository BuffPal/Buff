<?php 
/**
 * 自定义函数文件
 */

function getNum($num){
  $numw = $num/10000;
  $numqw = $num/10000000;
  $numy = $num/100000000;
  if($numw > 1){$num = round($numw,2).'万';}
  if($numqw > 1){$num = round($numqw,2).'千万';}
  if($numy > 1){$num = round($numy,2).'亿';}
  return $num;
}


/**
 * 字节自动转换函数
 * @param [int] $sizeb [需要转换的字节]
 */
function getSize ($sizeb) {
  $sizekb = $sizeb / 1024;
  $sizemb = $sizekb / 1024;
  $sizegb = $sizemb / 1024;
  $sizetb = $sizegb / 1024;
  $sizepb = $sizetb / 1024;
  if ($sizeb > 1) {$size = round($sizeb,2) . "b";}
  if ($sizekb > 1) {$size = round($sizekb,2) . "kb";}
  if ($sizemb > 1) {$size = round($sizemb,2) . "M";}
  if ($sizegb > 1) {$size = round($sizegb,2) . "G";}
  if ($sizetb > 1) {$size = round($sizetb,2) . "tb";}
  if ($sizepb > 1) {$size = round($sizepb,2) . "pb";}
  return $size;
}

  //thinkphp 自动验证 验证是否为 '';
  function checkEmpty($data){
    if(is_numeric($data)){
      return true;
    }else{
      return false;
    }
  }

/**
 * 格式化打印数组
 */
  function p($arr){
    UTF8();
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

/**
 * 加强版本的trim 能过滤全交空格
 * @param  [string] $string [需要过滤字符串]
 * @return [string]         [过滤完成字符串]
 */
function trimStrong($string){
  //$string = mb_ereg_replace('^(([ \r\n\t])*(　)*)*', '', $string);  只去掉头部
  //$string = mb_ereg_replace('(([ \r\n\t])*(　)*)*$', '', $string);   只去掉尾部
  //下面俩是全部去除
  $string = mb_ereg_replace('(([ \r\n\t])*(　)*)*', '', $string);
  $string = mb_ereg_replace('(([ \r\n\t])*(　)*)*', '', $string);
  return $string;
}


/* 
 *根据腾讯IP分享计划的地址获取IP所在地，比较精确 
 */ 

function getIPLoc_QQ($queryIP){ 
    $url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$queryIP; 
    $ch = curl_init($url); 
    curl_setopt($ch,CURLOPT_ENCODING ,'gb2312'); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
    $result = curl_exec($ch); 
    $result = mb_convert_encoding($result, "utf-8", "gb2312"); // 编码转换，否则乱码 
    curl_close($ch); 
    preg_match("@<span>(.*)</span></p>@iU",$result,$ipArray); 
    $loc = $ipArray[1]; 
    return $loc; 
} 

/**
   * 无限极分类递归
   * @param  [type]  $cate  [数组，主要用里面的Pidy分类]
   * @param  string  $html  [分隔符，如br标签，主要是为了让他能更明显的看出来谁是谁的子类]
   * @param  integer $pid   [就是子类的父id默认是0，因为祖先级元素没有父级]
   * @param  integer $level [一方面是用这个来使得子类的分隔符能成倍的增加，更明显，一方面是为了在列表视图中的级别显示出来]
   * @return [type]         [description]
   */
  ///第一种分类方法，不带数组只是一个排序                  组合一维数组
  function unlimitedForLevel($cate,$html='——',$pid=0,$level=0){
    $arr=array();
    foreach ($cate  as $v) {
      if($v['fid']==$pid){//第一次运行的时候是判断是不是祖先级元素，因为没有父级
        $v['level']=$level+1;
        $v['html']=str_repeat($html,$level);//str_repeat这个函数是填充，就是用level的数字来填充多少次$html---注意这里的level依然是0
        $arr[]=$v;//虽然是foreach循环但是$arr[]是一个叠加的状态，并不会覆盖里面的值
        $arr = array_merge($arr,unlimitedForLevel($cate,$html,$v['id'],$level+1));//array_merge是合并数组，把两个数组合并一起，默认第一个数在最上面,注意这里的$level取的是0，但子类收到的是1
      }//因为计算原理所以，上面的数组先是把每个祖先级的数组，找到全部的子类然后在开始下一个祖先级
    }
    return $arr;
  }
  //跟RBAC里面的无限极一样带数组                          组合多维数组
  function unlimitedForLayer($cate,$pid=0){
    $arr =array();
    foreach ($cate as $v) {
     if($v['fid']==$pid){
      $v['child']=unlimitedForLayer($cate,$v['id']);
      $arr[]=$v;
     }
    }
    return $arr;
  }
  //通过一个子类找全部的父类                       传递一个子级ID 返回所有父级ID
  function getParents($cate,$id){
    $arr = array();
    foreach ($cate as $v) {
       if($v['id']==$id){
        $arr[] =$v;
        $arr = array_merge(getParents($cate,$v['fid']),$arr);//这是一个数组合并的函数，默认第一个在最前面,能达到更改foreach的指针熟顺序
      }
    }
    return $arr;
  }
  //传递一个父级分类ID返回所有子分类ID
  function getChildsID ($cate,$pid){
  $arr = array();
  foreach ($cate as $v) {
    if ($v['fid']==$pid) {
        $arr[]=$v['id'];
        $arr=array_merge($arr,getChildsID($cate,$v['id']));
    }
  }
  return $arr;
  }


/**
 * 正则收集
 */
function zhengzhe(){
  //判断特殊字符
  $a = "/\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\||\ |\　/";
  //邮箱验证
  $b = '/w+([-+.]w+)*@w+([-.]w+)*.w+([-.]w+)*/';
  //网址验证
  $c = '/(?:http:\/\/)?([\w.]+[\w\/]*\.[\w.]+[\w\/]*\??[\w=\&\+\%]*)/is';
}