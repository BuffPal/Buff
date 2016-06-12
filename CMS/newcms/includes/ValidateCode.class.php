<?php 
/**
 * 验证码类
 */
class ValidateCode{
  private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//随机因子
  private $code;          //验证码
  private $codeLen = 4;   //验证码长度
  private $width = 130;   //宽度
  private $height = 50;   //高度
  private $img;           //图形资源句柄  
  private $font;          //指定字体
  private $fontsize = 20; //指定字体大小
  private $fontcolor;     //字体颜色随机

  public function __construct(){
    $this->font = ROOT_PATH.'/font/elephant.ttf';
  }

  //生产验证码
  private function createCode(){
    $len = strlen($this->charset)-1;
    for($i = 0;$i < $this->codeLen;$i++){
      $this->code .= $this->charset[mt_rand(0,$len)];
    }
  }

  //生成背景
  private function createBg(){
    $this->img = imagecreatetruecolor($this->width, $this->height);
    $color = imagecolorallocate($this->img, mt_rand(180,255), mt_rand(180,255), mt_rand(180,255));
    imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
  }

  //生成文字
  private function createFont(){
    $x = $this->width / $this->codeLen;
    for($i = 0;$i<$this->codeLen;$i++){
      $this->fontcolor = imagecolorallocate($this->img,mt_rand(0,140),mt_rand(0,140),mt_rand(0,140));
      imagettftext($this->img,$this->fontsize,mt_rand(-25,25),$x*$i+mt_rand(1,5),$this->height/1.4,$this->fontcolor,$this->font,$this->code[$i]);     //200课
    }
  }

  //生成线条雪花
  private function createLine(){
    for($i=0;$i<6;$i++){//线条
      $color = imagecolorallocate($this->img,mt_rand(0,140),mt_rand(0,140),mt_rand(0,140));
      imageline($this->img,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
    }
    for($i=0;$i<100;$i++){
      $color = imagecolorallocate($this->img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
      imagestring($this->img,mt_rand(1,5),mt_rand(1,$this->width),mt_rand(1,$this->height),'*',$color);
    }
  }

  //输出图形
  private function outPut(){
      ob_clean();
      header('Content-type:image/png');
      imagepng($this->img);
      imagedestroy($this->img);   //销毁这个句柄
  }

  //对外输出方法
  public function doimg(){
    $this->createBg();
    $this->createCode();
    $this->createLine();
    $this->createFont();
    $this->outPut();
  }

  //获取验证码
  public function getCode(){
    return sha1(strtolower($this->code));
  }

}
 ?>