@extends('public.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{ url('admin/info') }}">首页</a> &raquo; 导航列表
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{ url('admin/nav/create') }}"><i class="fa fa-plus"></i>添加链接</a>
                    <a href="{{ url('admin/nav') }}"><i class="fa fa-recycle"></i>更新列表</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">排序</th>
                        <th class="tc">编号</th>
                        <th>导航名称</th>
                        <th>英文导航名</th>
                        <th>跳转url</th>
                        <th>操作</th>
                    </tr>
                    @if(count($navs) > 0)
                        @foreach($navs as $k => $v)
                            <tr>
                                <td class="tc">
                                    <input type="text" onchange="changeOrder(this,'{{ $v->id }}')" value="{{ $v->order }}">
                                </td>
                                <td class="tc">{{ $k +1}}</td>
                                <td>
                                    {{ $v->name }}
                                </td>
                                <td>{{ $v->ename }}</td>
                                <td><a href="{{ $v->url }}">{{ $v->url }}</a></td>
                                <td>
                                    <a href="{{ url('admin/nav/'.$v->id.'/edit') }}">修改</a>
                                    <a href="javascript:;" onclick="de({{ $v->id }},this)">删除</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td><h1>木有数据</h1></td></tr>
                    @endif
                </table>

            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->

    <!--- 引入  JS文件 --->
    <script language="JavaScript" type="text/javascript">
        function changeOrder(obj,id) {
            var order = $(obj).val();
            $.post('{{ url('admin/nav/changeOrder') }}',{
                '_token':'{{ csrf_token() }}',
                'id':id,
                'order':order
            },function(data){
                if(data.status){
                    layer.msg(data.msg, {icon: 1});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            },'json');
        }

        //删除 AJAX处理
        function de(id,obj){
            layer.confirm('您确定要删除吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post('{{ url('admin/nav') }}/'+id,{
                    '_token':'{{ csrf_token() }}',
                    '_method':'delete',
                    'id':id
                },function(data){
                    if(data.status){
                        layer.msg(data.msg, {icon: 1});
                        var oTr = $(obj).closest('tr');
                        oTr.fadeOut("slow",function(){
                            oTr.remove();
                        });
                    }else{
                        layer.msg(data.msg, function(){});
                    }

                },'json');

            });
        }
    </script>
    @if(session('success'))
        <script language="JavaScript" type="text/javascript">
            layer.msg('{{ session('success') }}', function () {
                
            });
        </script>
    @endif
@stop