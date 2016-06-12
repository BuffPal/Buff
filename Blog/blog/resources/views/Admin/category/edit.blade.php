@extends('public.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ asset('admin/info') }}">首页</a> &raquo; <a href="{{ asset('admin/category') }}">分类列表</a> &raquo; 编辑分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/category/create') }}"><i class="fa fa-plus"></i>添加分类</a>
                <a href="{{ url('admin/category') }}"><i class="fa fa-recycle"></i>分类列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{ url('admin/category/'.$field->id) }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>父级分类：</th>
                        <td>
                            <select name="pid">
                                <option value="0">==默认根分类==</option>
                                @if($parent)
                                    @foreach($parent as $v)
                                        <option value="{{ $v->id }}"
                                        @if($field->pid == $v->id)
                                            selected
                                        @endif
                                        >{{ $v->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>分类名：</th>
                        <td>
                            <input type="text" name="name" value="{{ $field->name }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请保证在2~20位之间</span>
                        </td>
                    </tr>
                    <tr>
                        <th>分类描述：</th>
                        <td>
                            <input type="text" class="lg" name="info" value="{{ $field->info }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请保证在100位之内</span>
                        </td>
                    </tr>
                    <tr>
                        <th>关键字：</th>
                        <td>
                            <input type="text" class="lg" name="keyword" value="{{ $field->keyword }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请用 &nbsp;&nbsp;&nbsp;, &nbsp;&nbsp;&nbsp;隔开</span>
                        </td>
                    </tr>
                    <tr>
                        <th>关键字描述：</th>
                        <td>
                            <textarea class="lg" name="description" style="resize: none;" placeholder="请保证在255位之内">{{ $field->description }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="order" value="{{ $field->order }}">
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