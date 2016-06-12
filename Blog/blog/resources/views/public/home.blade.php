<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ Config::get('web.web_title')}} - {{ Config::get('web.seo_title') }}</title>
    <meta name="keywords" content="{{ Config::get('web.web_keyword') }}" />
    <meta name="description" content="{{ Config::get('web.web_description') }}" />
    <link href="{{ asset('Home/css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('Home/css/index.css') }}" rel="stylesheet">
    <link href="{{ asset('Home/css/new.css') }}" rel="stylesheet">
    <link href="{{ asset('Home/css/style.css') }}" rel="stylesheet">
    <!--- 引入 Bootstarp css文件 --->
    <link rel="stylesheet" href="{{ asset('Public/css/bootstrap.min.css') }}">
    <!--[if lt IE 9]>
    <script src="{{ asset('Home/js/modernizr.js') }}"></script>
    <![endif]-->
</head>
<body>
<header>
    <div id="logo"><a href="/"></a></div>
    <nav class="topnav" id="topnav">
        @if($navs)
            @foreach($navs as $v)<a href="{{ $v->url }}"><span>{{ $v->name }}</span><span class="en">{{ $v->ename }}</span></a>@endforeach
        @endif
    </nav>
</header>
<div class="banner">
    <section class="box">
        <ul class="texts">
            <p>{{ Config::get('web.p_1') }}</p>
            <p>{{ Config::get('web.p_2') }}</p>
            <p>{{ Config::get('web.p_3') }}</p>
        </ul>

        <div class="avatar"><a href="#" style="background-image: url('{{ asset('img/buff.jpg') }}')"><span>{{ Config::get('web.username') }}</span></a> </div>
    </section>
</div>
<div class="template">
    <div class="box">
        <h3>
            <p><span>站长</span>推荐 Recommend</p>
        </h3>
        <ul>
            @if(count($hot) > 0)
                @foreach($hot as $v)
                    <li><a href="{{ url('/article').'/'.$v->id }}"  target="_blank"><img src="{{ asset($v->thumb) }}"></a><span>{{ $v->title }}</span></li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

@yield('content')
<footer>
    <p>{{ Config::get('web.web_footer') }}　　<a href="/">网站统计</a></p>
</footer>
</body>
</html>
