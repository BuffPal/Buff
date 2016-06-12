<?php
  namespace Index\Controller;
  use Think\Controller;
Class ArticleController extends Controller{

   //首页显示
   Public function index(){
      $this->navTitle = '文章';
      $this->display();
   }
}