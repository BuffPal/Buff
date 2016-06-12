
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    {{--引入 bootstrap--}}
    <link rel="stylesheet" href="{{ asset('Public/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('Public/css/bootstrap-theme.css') }}">

    <link rel="stylesheet" href="{{ asset('Admin/css/ch-ui.admin.css') }}">
    <link rel="stylesheet" href="{{ asset('Admin/font/css/font-awesome.min.css') }}">
    <script type="text/javascript" src="{{ asset('Admin/js/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('Admin/js/ch-ui.admin.js') }}"></script>
    <!--- 引入 bootstrap JS文件 --->
    <script language="JavaScript" type="text/javascript" src="{{ asset('Public/js/bootstrap.min.js') }}"></script>
    <!--- 引入 工具类 JS文件 --->
    <script language="JavaScript" type="text/javascript" src="{{ asset('Admin/js/Tool.js') }}"></script>
    <!--- 引入 layer弹出效果 JS文件 --->
    <script language="JavaScript" type="text/javascript" src="{{ asset('org/layer/layer.js') }}"></script>
</head>
<body>
@yield('content')
@if( session('alert'))
    <script language="JavaScript" type="text/javascript">
        layer.msg('{{ session('alert') }}', {icon: '{{ session('alertNum') }}'});
    </script>
@endif
<script language="JavaScript" type="text/javascript">
    //文章AJAX删除
    function deleteArticle(obj,id){
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.post('{{ url('admin/article') }}/'+id,{
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
</body>
</html>