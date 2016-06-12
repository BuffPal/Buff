@extends('public.home')
@section('content')
<article>
  <h2 class="title_tj">
    <p>最新<span>文章</span></p>
  </h2>
  <div class="bloglist left">
    @if(count($data)>0)
      @foreach($data as $v)
        <h3>{{ $v->title }}</h3>
        <figure><img src="{{ asset($v->thumb) }}"></figure>
        <ul>
          <p>{{ $v->info }}</p>
          <a title="{{ $v->title }}" href="{{ url('/article').'/'.$v->aid }}" target="_blank" class="readmore">阅读全文>></a>
        </ul>
        <p class="dateview">　<span> {{ date('Y-m-d',$v->time) }}</span><span>作者：{{ $v->editor }}</span><span>所属栏目：[<a href="{{ url('/lists').'/'.$v->cid }}" target="_blank">{{ $v->name }}</a>]</span></p>
      @endforeach
    @endif
    {{ $data->links() }}
  </div>
  <!-- Baidu Button BEGIN -->
  <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
  <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
  <script type="text/javascript" id="bdshell_js"></script>
  <script type="text/javascript">
    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
  </script>
  <!-- Baidu Button END -->
  <aside class="right">
    <div class="weather"><iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe></div>
    <div class="news">
    <h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
      @if(count($new) > 0)
        @foreach($new as $v)
      <li><a href="{{ url('/article').'/'.$v->id }}" title="Column 三栏布局 个人网站模板" target="_blank">{{ $v->title }}</a></li>
        @endforeach
      @else
        <li>暂时没有数据</li>
      @endif
     </ul>
    <h3 class="ph">
      <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
      @if(count($hot5) > 0)
        @foreach($hot5 as $v)
          <li><a href="/" title="{{ $v->info }}" target="_blank">{{ $v->title }}</a></li>
        @endforeach
      @endif
    </ul>
    <h3 class="links">
      <p>友情<span>链接</span></p>
    </h3>
    <ul class="website">
      @if(count($link) > 0)
        @foreach($link as $v)
          <li><a href="{{ $v->url }}" target="_blank">{{ $v->name }}</a></li>
        @endforeach
      @else
        <li>暂时木有数据~</li>
      @endif
    </ul>
    </div>
    </aside>
</article>
@stop
