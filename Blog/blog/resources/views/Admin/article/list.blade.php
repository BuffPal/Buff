@extends('public.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a>  &raquo; 文章列表
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="{{ url('admin/article/search') }}" method="post">
            {{ csrf_field() }}
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="{{ url('admin/article') }}">==全部==</option>
                            @if($cate)
                                @foreach($cate as $v)
                                    <option value="{{ url('admin/article/').'/'.$v['id'] }}">{{ $v['html'] }}{{ $v['name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询" class="btn btn-primary"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/article/create') }}"><i class="fa fa-plus"></i>新增文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">编号</th>
                        <th>标题</th>
                        <th>点击</th>
                        <th>编辑</th>
                        <th>发布时间</th>
                        <th>分类</th>
                        <th>操作</th>
                    </tr>
                    @if($article)
                        @foreach($article as $k=>$v)
                            <tr>
                                <td class="tc">{{ $k+($article->currentPage()-1)*env('ADMIN_PAGE_SIZE')+1 }}</td>
                                <td>
                                    <a href="#">{{ $v->title }}</a>
                                </td>
                                <td>{{ $v->count }}</td>
                                <td>{{ $v->editor }}</td>
                                <td>{{ date('Y-m-d H:i:s',$v->time) }}</td>
                                <td><a href="{{ url('admin/article').'/'.$v->cid }}">{{ $v->name }}</a></td>
                                <td>
                                    <a href="{{ url('admin/article/'.$v->aid.'/edit') }}">修改</a>
                                    <a href="javascript:;" onclick="deleteArticle(this,'{{ $v->aid }}');">删除</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td>木有数据</td>
                    </tr>
                    @endif
                </table>
                <style>
                    .pagination{
                        margin-left:40%;
                    }
                </style>
                {!! $article->links() !!}
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
@stop