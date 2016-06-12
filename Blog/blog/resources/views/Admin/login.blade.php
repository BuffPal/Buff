<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="{{ asset('Admin/css/ch-ui.admin.css') }}">
	<link rel="stylesheet" href="{{ asset('Admin/font/css/font-awesome.min.css') }}">
</head>
<body style="background:#F3F3F4;">
	<div class="login_box">
		<h1>Blog</h1>
		<h2>欢迎使用博客管理平台</h2>
		<div class="form">

			@if(session('msg'))
			<p style="color:#ff8410;linhei">{{ session('msg') }}</p>
			@endif

			<form action="{{ URL('admin/login') }}" method="post">
				<ul>
					<li>
					<input type="text" name="account" class="text"/>
						<span><i class="fa fa-user"></i></span>
					</li>
					<li>
						<input type="password" name="password" class="text"/>
						<span><i class="fa fa-lock"></i></span>
					</li>
					<li>
						<input type="text" class="code" name="code"/>
						<span><i class="fa fa-check-square-o"></i></span>
						<img src="{{ url('/code') }}" onclick="this.src=this.src+'?'+Math.random()" style="cursor: pointer;">
					</li>
					<li>
						<input type="submit" value="立即登陆"/>
					</li>
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</ul>
			</form>
			<p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.baidu.com" target="_blank">http://www.baidu.com</a></p>
		</div>
	</div>
</body>
</html>