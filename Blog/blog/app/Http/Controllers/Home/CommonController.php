<?php

namespace App\Http\Controllers\Home;

use App\Model\articles;
use App\Model\links;
use App\Model\navs;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        //获取自定义导航
        $navs = navs::orderBy('order','asc')->get();
        View::share('navs',$navs);

        //获取最热的6篇文章
        $hot = articles::orderBy('count','desc')->take(6)->select('title','id','thumb')->get();
        View::share('hot',$hot);

        //获取最热的5篇文章
        $hot5 = articles::orderBy('count','desc')->take(5)->select('title','id','info')->get();
        View::share('hot5',$hot5);

        //最新发布的8篇文章
        $new = articles::orderBy('time','desc')->take(8)->select('title','id')->get();
        View::share('new',$new);

        //友情链接
        $link = links::orderBy('order','asc')->take(5)->select('name','url')->get();
        View::share('link',$link);
    }
}
