@extends('public.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ asset('admin/info') }}">首页</a> &raquo; <a href="{{ asset('admin/config') }}">配置项列表</a> &raquo; 修改配置项
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{ url('admin/config') }}"><i class="fa fa-recycle"></i>配置项列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{ url('admin/config').'/'.$data->id }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="put">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" class="md" name="title" value="{{ $data->title }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请保证在20位之内</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" class="md" name="name" value="{{ $data->name }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>请保证在20位之内</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio" name="type" value="input" @if($data->type == 'input') checked @endif onclick="showTr()"> input　　
                            <input type="radio" name="type" value="textarea" @if($data->type == 'textarea') checked @endif onclick="showTr()"> textarea　　
                            <input type="radio" name="type" value="radio" @if($data->type == 'radio') checked @endif onclick="showTr()"> radio
                        </td>
                    </tr>
                    <tr class="value" @if($data->type != 'radio')  style="display: none; @endif  ">
                        <th>类型值：</th>
                        <td>
                            <input type="text" class="md" name="value" value="{{ $data->value }}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>只有在选着类型为 radion的时候才需要配置 格式为 1|开启,0|关闭</span>
                        </td>
                    </tr>
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="order" value="{{ $data->order }}">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="tips" class="lg">{{ $data->tips }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交" class="btn btn-primary">
                            <input type="button" class="back btn" onclick="history.go(-1)" value="返回">
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
    <script>
        function showTr() {
            var type = $('input[name=type]:checked').val();
            if(type == 'radio'){
                $('tr.value').fadeIn();
            }else{
                $('tr.value').fadeOut();
            }
        }
    </script>
@stop