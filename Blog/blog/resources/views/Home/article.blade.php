@extends('public.home')
@section('content')
<article class="blogs">
  <h1 class="t_nav"><span>您当前的位置：首页&nbsp;&gt;&nbsp;
      @if(count($category) > 0)
        @foreach($category as $v)
          {{ $v->name }}&nbsp;&gt;&nbsp;
        @endforeach
      @endif
    {{ omitString($data->title,20) }}</span>

    <a href="/" class="n1">网站首页</a>
    @if(count($category) > 0)
      @foreach($category as $k=>$v)
        <a href="{{ url('/lists').'/'.$v->id }}" class="n{{ $k+1 }}">{{ $v->name }}</a>
      @endforeach
    @endif
  </h1>
  <div class="index_about">
    <h2 class="c_titile">{{ $data->title }}</h2>
    <p class="box_c"><span class="d_time">发布时间：{{ date('Y-m-d',$data->time) }}</span><span>编辑：{{ $data->editor }}</span><span>查看次数：{{ $data->count }}</span></p>
    <ul class="infos">
        {!! $data->content !!}
    </ul>
    <div class="keybq">
    <p><span>关键字词</span>：{!! $data->tag !!}</p>


    </div>
    <div class="ad"> </div>
    <div class="nextinfo">
      <p>上一篇：<a href="/news/s/2013-09-04/606.html">程序员应该如何高效的工作学习</a></p>
      <p>下一篇：<a href="/news/s/2013-10-21/616.html">柴米油盐的生活才是真实</a></p>
    </div>
    <div class="otherlink">
      <h2>相关文章</h2>
      <ul>
        <li><a href="/news/s/2013-07-25/524.html" title="现在，我相信爱情！">现在，我相信爱情！</a></li>
        <li><a href="/newstalk/mood/2013-07-24/518.html" title="我希望我的爱情是这样的">我希望我的爱情是这样的</a></li>
        <li><a href="/newstalk/mood/2013-07-02/335.html" title="有种情谊，不是爱情，也算不得友情">有种情谊，不是爱情，也算不得友情</a></li>
        <li><a href="/newstalk/mood/2013-07-01/329.html" title="世上最美好的爱情">世上最美好的爱情</a></li>
        <li><a href="/news/read/2013-06-11/213.html" title="爱情没有永远，地老天荒也走不完">爱情没有永远，地老天荒也走不完</a></li>
        <li><a href="/news/s/2013-06-06/24.html" title="爱情的背叛者">爱情的背叛者</a></li>
      </ul>
    </div>
  </div>
  <aside class="right">
    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
    <!-- Baidu Button END -->
    <div class="blank"></div>
    <div class="news">
      <h3>
        <p>栏目<span>最新</span></p>
      </h3>
      <ul class="rank">
        @if(count($new) > 0)
          @foreach($new as $v)
            <li><a href="{{ url('/article').'/'.$v->id }}" title="{{ $v->info }}" target="_blank">{{ $v->title }}</a></li>
          @endforeach
        @endif

      </ul>
      <h3 class="ph">
        <p>点击<span>排行</span></p>
      </h3>
      <ul class="paih">
        @if(count($hot5) > 0)
          @foreach($hot5 as $v)
            <li><a href="{{ url('/article').'/'.$v->id }}" title="{{ $v->info }}" target="_blank">{{ $v->title }}</a></li>
          @endforeach
        @endif
      </ul>
    </div>
    <div class="visitors">
      <h3>
        <p>最近访客</p>
      </h3>
      <ul>
      </ul>
    </div>
  </aside>
</article>
@stop