@extends('public.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 导航列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/pic/create') }}"><i class="fa fa-plus"></i>添加图片</a>
                    <a href="{{ url('admin/pic') }}"><i class="fa fa-recycle"></i>更新列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>
        <style>
            img.user_pic{
                width: 130px;
                height:130px;
                border:3px solid #fff;
                box-shadow: 0px 0px 5px #333;
                display: block;
                border-radius: 50%;
                margin-top:20px;
            }
            img.bg{
                width: 800px;
                height:111px;
                border:3px solid #fff;
                box-shadow: 0px 0px 5px #333;
                display: block;
                margin-top:20px;
            }
            img.logo{
                width: 260px;
                height:60px;
                border:3px solid #fff;
                box-shadow: 0px 0px 5px #333;
                display: block;
                margin-top:20px;
            }
        </style>
        <div>
            <p>　</p>
            <h3 class="text-center">LOGO</h3>
            <img src="" alt="" class="logo center-block">
            <p>　</p>
            <p class="text-center"><a class="btn btn-primary" href="{{ url('admin/pic/logo') }}">修改LOGO</a></p>
        </div>
        <div class="container">
            <div>
                <p>　</p>
                <h3 class="text-center">站长头像</h3>
                <img src="" alt="" class="user_pic center-block">
                <p>　</p>
                <p class="text-center"><a class="btn btn-primary" href="{{ url('admin/pic/pic') }}">修改头像</a></p>
            </div>
        </div>
        <div>
            <p>　</p>
            <h3 class="text-center">首页背景</h3>
            <img src="" alt="" class="bg center-block">
            <p>　</p>
            <p class="text-center"><a class="btn btn-primary" href="{{ url('admin/pic/bg') }}">修改背景</a></p>
        </div>
    </form>
    @if(session('success'))
        <script language="JavaScript" type="text/javascript">
            layer.msg('{{ session('success') }}', function () {
                
            });
        </script>
    @endif
@stop