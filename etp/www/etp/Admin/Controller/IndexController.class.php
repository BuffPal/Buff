<?php
/**
 * 后台主页控制器
 */
namespace Admin\Controller;
use Admin\Controller;
class IndexController extends CommonController {
    //主要显示
    Public function index(){
      $this->display();
    }

    //头部页面
    Public function header(){
      $this->display();
    }

    //侧栏页面
    Public function sidebar(){
      $this->display();
    }

    //main后台首页
    Public function main(){
      $this->display();
    }


}