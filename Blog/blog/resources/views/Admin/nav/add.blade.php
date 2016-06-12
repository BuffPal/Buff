@extends('public.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ asset('admin/info') }}">首页</a> &raquo; <a href="{{ asset('admin/category') }}">分类列表</a> &raquo; 添加分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/nav') }}"><i class="fa fa-recycle"></i>链接列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{ url('admin/nav') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>导航名：</th>
                        <td>
                            <input type="text" class="lg" name="name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请保证在20位之内</span>
                        </td>
                    </tr>
                    <tr>
                        <th>导航英文名：</th>
                        <td>
                            <input type="text" class="lg" name="ename">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请保证在50位之内</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>跳转地址：</th>
                        <td>
                            <input type="text" class="lg" name="url" value="http://">
                            <span></span>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交" class="btn btn-primary">
                            <input type="button" class="back btn" onclick="history.go(-1)" value="返回" >
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    @if($errors->any())
        <ul class="list-group">
        @foreach($errors->all() as $error)
    	    <li class="list-group-item list-group-item-danger text-center">{{ $error }}</li>
        @endforeach
        </ul>
    @endif
    @if(session('msg'))
        <li class="list-group-item list-group-item-danger text-center">{{ session('msg') }}</li>
    @endif
@stop