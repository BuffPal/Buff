@extends('public.admin')
@section('content')
<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title text-center">
        <h1>修 改 密 码</h1>
    </div>
</div>
<div style="width: 400px;margin: 0 auto;padding-top: 20px; ">
{{ Form::open(['url'=>'admin/pass']) }}
<!--- 旧密码 Field --->
<div class="form-group">
    {!! Form::label('password_o', '旧密码*:') !!}
    {!! Form::password('password_o', ['class' => 'form-control']) !!}
</div>
<!--- 新密码 Field --->
<div class="form-group">
    {!! Form::label('password', '新密码*:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>
<!--- 确认密码 Field --->
<div class="form-group">
    {!! Form::label('password_confirmation', '确认密码*:') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>
    {!! Form::submit('修改',['class'=>'btn btn-primary btn-block btn-lg']) !!}
    <br>
    <br>
    <a href="{{ url('admin/index') }}" class="btn btn-default btn-block">返回</a>

{{ Form::close() }}
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