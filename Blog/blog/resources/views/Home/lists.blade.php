@extends('public.home')
@section('content')
<article class="blogs">
<h1 class="t_nav"><span>{{ $cateInfo }}</span>
    <a href="{{ url('/') }}" class="n1">网站首页</a>
    @if(count($category) > 0)
        @foreach($category as $k=>$v)
            <a href="{{ url('/lists').'/'.$v->id }}" class="n{{ $k+1 }}">{{ $v->name }}</a>
        @endforeach
    @endif
</h1>
<div class="newblog left">
    @if(count($data) > 0)
        @foreach($data as $v)
           <h2>{{ $v->title}}</h2>
           <p class="dateview"><span>　发布时间:{{ date('Y-m-d',$v->time) }}</span><span>作者：{{ $v->editor }}</span><span>所属栏目：[<a href="{{ url('/lists').'/'.$v->cid }}">{{ $v->name }}</a>]</span></p>
            <figure><img src="{{ asset($v->thumb) }}"></figure>
            <ul class="nlist">
              <p>{{ $v->info }}……</p>
              <a title="{{ $v->info }}" href="{{ url('/article').'/'.$v->aid }}" target="_blank" class="readmore">阅读全文>></a>
            </ul>
            <div class="line"></div>
        @endforeach
    @else
        <h1>木有数据!</h1>
    @endif

    {{ $data->links() }}
</div>
<aside class="right">
   <div class="rnav">
      <ul>
          @if(count($child) > 0)
              @foreach($child as $k=>$v)
                    <li class="rnav{{ $k+1 }}"><a href="{{ url('/lists').'/'.$v->id }}">{{ $v->name }}</a></li>
              @endforeach
          @endif
     </ul>
    </div>
<div class="news">
<h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @if(count($newCate) > 0)
            @foreach($newCate as $v)
                <li><a href="{{ url('/article').'/'.$v->id }}" title="{{ $v->info }}">{{ $v->title }}</a></li>
            @endforeach
        @endif
    </ul>
    <h3 class="ph">
      <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @if(count($clickData) > 0 )
            @foreach($clickData as $v)
                <li><a href="{{ url('/article').'/'.$v->id }}" title="{{ $v->info }}" target="_blank">{{ $v->title }}</a></li>
            @endforeach
        @endif
    </ul>
    </div>
    <div class="visitors">
      <h3><p>最近访客</p></h3>
      <ul>

      </ul>
    </div>
     <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
    <script type="text/javascript" id="bdshell_js"></script>
    <script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
    <!-- Baidu Button END -->
</aside>
</article>
@stop